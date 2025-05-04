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
    <div class="attachements w-full bg-white">
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
          @input="addFiles"
          type="file"
          name="attachment"
          class="hidden w-full"
          :accept="allowedExtenstions.join()"
          :id="id"
          :disabled="attrs.modelValue.length >= props.maxFiles"
          ref="fileInput"
          multiple
        />

        <div class="text-md flex items-center gap-2">
          <FileIcon />
          <p>
            <span class="font-poppins fw-600 text-gray-500">
              {{ $t(props.placeholder) }}
            </span>
            <br />
            <span class="text-gray-400"
              >({{ allowedExtenstionsUpercase }}) {{ $t(helpText) }}
            </span>
          </p>
        </div>
      </label>
      <!-- <p class="text-error"  v-if="errorMessage">
          {{ $t(errorMessage) }}
      </p> -->
      <p class="text-error" v-if="localError">
        {{ $t(localError) }}
      </p>
    </div>
    <div
      class="flex flex-wrap flex-grow gap-2 overflow-x-scroll rounded-md files"
    >
      <template v-if="props.showFileNames">
        <div
          class="relative gap-2 group rounded-md text-gray-500 hover:text-gray-700"
          v-for="(file, index) in attrs.modelValue"
          :key="index"
        >
          <a :href="generateUrl(file)" target="_blank">
            <AttachmentIcon class="inline-block" />
            {{ file.name }}
          </a>
          <RemoveIcon
            @click.stop="() => removeFile(index)"
            @mouseover="focused = true"
            class="align-middle inline-block cursor-pointer text-gray-500 group-hover:text-gray-700 mr-auto ml-2 top-1"
          />
        </div>
      </template>
      <template v-else>
        <div
          class="relative min-w-[150px] min-h-[150px] max-w-[150px] max-h-[150px] group rounded-md overflow-hidden"
          v-for="(file, index) in attrs.modelValue"
          :key="index"
        >
          <a :href="generateUrl(file)" target="_blank">
            <div
              v-if="
                file.type == 'application/pdf' || file.path?.slice(-4) == '.pdf'
              "
              class="flex items-center justify-center w-full h-full text-[30px] text-red-500 bg-gray-300 cursor-pointer"
            >
              {{ $t("PDF") }}
            </div>
            <img v-else class="w-full h-full" :src="generateUrl(file)" />
          </a>
          <div
            class="absolute top-0 left-0 items-end justify-center w-full h-full pb-2 bg-gray-100/[30%] hidden group-hover:flex"
          >
            <DeleteAttachment
              @click.stop="() => removeFile(index)"
              class="w-[30px] left-[50%] cursor-pointer"
            />
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import { v4 as uuid } from "uuid";
import {
  ref,
  inject,
  defineExpose,
  onMounted,
  onUnmounted,
} from "@vue/runtime-core";
import { useAttrs, defineProps, computed } from "vue";
import DeleteAttachment from "@/components/icons/DeleteAttachmentIcon.vue";
import AttachmentIcon from "@/components/icons/AttachmentIcon.vue";
import FileIcon from "@/components/icons/FileIcon.vue";
import RemoveIcon from "@/components/icons/RemoveIcon.vue";
import { trans } from "laravel-vue-i18n";
const $vfm = inject("$vfm");

const id = uuid();
const attrs = useAttrs();
const fileInput = ref(null);
const dropZone = ref(null);
const focused = ref(false);
const emit = defineEmits(["update:modelValue"]);
const props = defineProps({
  placeholder: {
    type: String,
    default: "Attach Receipts",
  },
  label: {
    type: String,
    default: "Attachments",
  },
  showFileNames: {
    type: Boolean,
    default: false,
  },
  maxFiles: {
    type: Number,
    default: 3,
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
  addFiles();
  focused.value = false;
};

const addFiles = () => {
  localError.value = null;
  if (
    fileInput.value.files.length + attrs.modelValue.length <=
    props.maxFiles
  ) {
    let incomingFiles = Array.from(fileInput.value.files);

    const fileExists = attrs.modelValue.some((r) =>
      incomingFiles.some((file) => file.name === r.name && file.size === r.size)
    );
    if (fileExists) {
      localError.value = "File is already selected";
      reset();
      return;
    }

    const fileSizeExceeds = incomingFiles.some(
      (file) => file.size / 1024 > props.maxFileSize
    );
    if (fileSizeExceeds) {
      localError.value = trans("Maximum file size :size MB allowed!", {
        size: props.maxFileSize / 1024,
      });
      reset();
      return;
    }

    const fileTypeExcluded = incomingFiles.some(
      (file) => !props.allowedExtenstions.includes(getFileExtension(file.name))
    );
    if (fileTypeExcluded) {
      localError.value = trans("Only :mimeslist files are allowed", {
        mimeslist: props.allowedExtenstions.join(),
      });
      reset();
      return;
    }

    emit("update:modelValue", [...attrs.modelValue, ...fileInput.value.files]);
    reset();
  } else {
    localError.value = trans("You can not attach more than :maxfiles files", {
      maxfiles: props.maxFiles,
    });

    reset();
  }

  emit("input");
};

const getFileExtension = (filename) => "." + filename.split(".").pop();

const removeFile = (index) => {
  emit(
    "update:modelValue",
    attrs.modelValue.filter((f, i) => i !== index)
  );
  return;
  // Remove item from server
  // emit(
  //   "removeFile",
  //   attrs.modelValue.filter((f, i) => i == index).id,
  // );
};

const showAlert = () => {
  localError.value = null;
  var fileLength = attrs.modelValue.length;
  if (fileLength == props.maxFiles) {
    localError.value = trans(`You can not attach more than :maxfiles files`, {
      maxfiles: props.maxFiles,
    });

    return;
  }
};

const generateUrl = (file) => {
  if ("url" in file) {
    return file.url;
  }
  return URL.createObjectURL(file);
};

const reset = () => (
  (fileInput.value.value = null), (fileInput.value.files = null)
);

const errorMessage = computed(() => {
  if (typeof props.error == "string" && props.error) {
    return props.error;
  } else if (typeof props.serverError == "string" && props.serverError) {
    return props.serverError;
  }

  return null;
});

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
  border: 1px solid #e97d32;
}

.text-error {
  margin-top: 3px;
  color: #dc3545;
//   font-size: 12px;
  line-height: 0.5rem;
  color: #e97d32;
  margin-top: 10px;

}
</style>
