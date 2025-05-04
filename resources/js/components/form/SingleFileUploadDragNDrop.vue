<template>
  <div class="input-element">
    <div
      :for="$attrs.id"
      class="block input-label"
      :class="$attrs.labelClass"
      v-if="label"
    >
      <template v-if="typeof $attrs.label == 'object'">
        {{ $t(label.text, label.replace) }}
      </template>
      <template v-else>
        {{ $t(label) }}{{ $attrs.asterisk ? "*" : "" }}
      </template>
    </div>
    <div class="attachements w-full bg-white" v-if="!attrs.modelValue">
      <label
        :class="$attrs.attachmentlabelClass"
        class="file-input flex flex-col px-4 py-12 z-10 cursor-pointer"
        :style="focused && 'border-color: green;'"
        :for="id"
        @click.stop="showAlert"
        @dragover="dragover"
        @dragleave="dragleave"
        @mouseover="focused = true"
        @mouseleave="focused = false"
        @drop="drop"
        ref="dropZone"
      >
        <input
          @input="addFile"
          type="file"
          name="attachment"
          class="hidden w-full"
          :accept="allowedExtenstions.join()"
          :id="id"
          :disabled="Boolean(attrs.modelValue)"
          ref="fileInput"
        />

        <div class="text-md flex items-center gap-2">
          <FileIcon />
          <p>
            <span class="font-poppins fw-600 text-gray-500">
              {{ $t(props.placeholder) }}
            </span>
            <br />
            <span class="text-gray-400"
              >({{ allowedExtenstionsUpercase }}) {{ $t(helpText) }}</span
            >
          </p>
        </div>
      </label>
    </div>
    <p class="text-error py-2" v-if="localError && !attrs.modelValue">
      {{ $t(localError) }}
    </p>

    <template v-if="existingFile && existingFile.length !== 0">
      <div class="overflow-x-scroll rounded-md files flex gap-2 flex-wrap">
        <div
          class="relative group rounded-md overflow-hidden min-w-[150px] max-w-[150px]"
        >
          <a :href="existingFile" target="_blank">
            <div
              v-if="existingFile?.slice(-4) === '.pdf'"
              class="flex items-center justify-center w-full h-full text-[30px] text-red-500 cursor-pointer mt-2"
            >
              <AttachmentIcon class="inline-block" />
              <div
                class="text-gray-500 text-[14px] group-hover:text-gray-700 ms-2"
              >
                Click to see PDF
              </div>
            </div>
            <img
              v-else
              class="min-w-[100px] max-w-[100px]"
              :src="existingFile"
            />
          </a>
        </div>
        <div class="flex items-center justify-center mt-3">
          <div class="cursor-pointer" @click.stop="removeFile">
            <RemoveIcon
              class="min-w-[24px] max-w-[24px] align-middle inline-block text-gray-500 group-hover:text-gray-700 mr-auto ml-2"
            />
            Remove File
          </div>
          <div class="cursor-pointer" @click.stop="deleteFile">
            <TrashIcon
              class="min-w-[24px] max-w-[24px] align-middle inline-block text-gray-500 group-hover:text-gray-700 mr-auto ml-2"
            />
            Delete File
          </div>
        </div>
      </div>
    </template>
    <template v-else>
      <div
        class="flex-grow gap-2 overflow-x-scroll rounded-md files flex flex-wrap"
        v-if="attrs.modelValue"
      >
        <div
          class="relative min-w-[100px] max-w-[100px] group rounded-md overflow-hidden"
        >
          <a :href="generateUrl(attrs.modelValue)" target="_blank">
            <div
              v-if="
                attrs.modelValue.type === 'application/pdf' ||
                attrs.modelValue.path?.slice(-4) === '.pdf'
              "
              class="flex items-center justify-center w-full h-full text-[30px] text-red-500 cursor-pointer mt-2"
            >
              <AttachmentIcon class="inline-block" />
              <div
                class="text-gray-500 text-[12px] truncate group-hover:text-gray-700 ms-2"
              >
                {{ attrs.modelValue.name }}
              </div>
            </div>
            <img
              v-else
              class="w-full h-full"
              :src="generateUrl(attrs.modelValue)"
            />
          </a>
        </div>
        <RemoveIcon
          @click.stop="removeFile"
          class="align-middle inline-block cursor-pointer text-gray-500 group-hover:text-gray-700 mr-auto ml-2 top-1 mt-3"
        />
      </div>
    </template>
  </div>
</template>

<script setup>
import { v4 as uuid } from "uuid";
import { ref, inject, defineExpose, watch } from "vue";
import { useAttrs, defineProps, computed } from "vue";
import AttachmentIcon from "@/components/icons/AttachmentIcon.vue";
import RemoveIcon from "@/components/icons/RemoveIcon.vue";
import FileIcon from "@/components/icons/FileIcon.vue";
import TrashIcon from "@/components/icons/DeleteAttachmentIcon.vue";
import { trans } from "laravel-vue-i18n";

const id = uuid();
const attrs = useAttrs();
const fileInput = ref(null);
const focused = ref(false);
const emit = defineEmits(["update:modelValue", "delete"]);
const props = defineProps({
  placeholder: {
    type: String,
    default: "Attach Receipt",
  },
  label: {
    type: String,
    default: "Attachment",
  },
  allowedExtenstions: {
    type: Array,
    default: [".jpg", ".png", ".jpeg", ".pdf"],
  },
  maxFileSize: {
    type: Number,
    default: 1024 * 5,
  },
  error: {
    type: [Boolean, String],
    required: false,
  },
  helpText: {
    type: String,
    default: null,
  },
  currentFile: {
    default: null,
  },
});

const localError = ref(null);

const allowedExtenstionsUpercase = computed(() => {
  return props.allowedExtenstions
    .map((i) => i.toUpperCase().replace(".", ""))
    .join(", ");
});

const dragleave = (e) => (focused.value = false);

const dragover = (e) => {
  e.preventDefault();
  focused.value = true;
};

const drop = (e) => {
  e.preventDefault();
  fileInput.value.files = e.dataTransfer.files;
  addFile();
  focused.value = false;
};

const addFile = () => {
  localError.value = null;
  const incomingFile = fileInput.value.files[0];

  if (attrs.modelValue) {
    localError.value = trans("Only one file can be attached");
    reset();
    return;
  }

  if (incomingFile.size / 1024 > props.maxFileSize) {
    localError.value = trans("Maximum file size :size MB allowed!", {
      size: props.maxFileSize / 1024,
    });
    reset();
    return;
  }

  if (!props.allowedExtenstions.includes(getFileExtension(incomingFile.name))) {
    localError.value = trans("Only :mimeslist files are allowed", {
      mimeslist: props.allowedExtenstions.join(),
    });
    reset();
    return;
  }

  emit("update:modelValue", incomingFile);
  reset();
  emit("input");
};

const getFileExtension = (filename) => "." + filename.split(".").pop();

const file = ref(props.currentFile);
const existingFile = computed(() => {
  return file.value;
});

watch(
  () => props.currentFile,
  (newValue) => {
    file.value = newValue;
  }
);

const removeFile = () => {
  file.value = null;
  emit("update:modelValue", null);
};

const deleteFile = () => {
  file.value = null;
  emit("delete", null);
};

const showAlert = () => {
  localError.value = null;
  if (attrs.modelValue) {
    localError.value = trans("Only one file can be attached");
  }
};

const generateUrl = (file) => {
  if (file instanceof File || file instanceof Blob) {
    return URL.createObjectURL(file);
  } else if (file && typeof file.url === "string") {
    return file.url;
  } else {
    emit("update:modelValue", null);
    return "";
  }
};

const reset = () => (
  (fileInput.value.value = null), (fileInput.value.files = null)
);

defineExpose({
  reset,
});
</script>

<style lang="scss" scoped>
.input-label {
  color: var(--Primary-Ball-Blue, #16a9b7);
  font-family: Poppins;
  font-size: 18px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
  margin-bottom: 12px;
}

.file-input {
  outline: none;
  color: #525f7f;
  font-size: 13px;
  font-style: normal;
  font-weight: 500;
  line-height: normal;
  letter-spacing: 0.13px;
  border-radius: 6px;
  border: 1px solid #dee2e6;
  color: #525f7f;
}

.overflow-x-scroll {
  overflow-x: auto;
}

.border-error {
  border: 1px solid #dc3545;
}

.text-error {
  margin-top: 3px;
  color: #dc3545;
  font-size: 12px;
  line-height: 0.5rem;
}
</style>
