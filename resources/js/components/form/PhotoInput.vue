<template>
  <div :class="$attrs.class">
    <div class="photo-input" :class="{ error: error }">
      <div class="file__input flex gap-4">
        <label
          v-if="!img && !defaultImage"
          class="photo-input__btn btn"
          :class="this.$attrs.labelClass"
          :for="id"
        >
          <div class="preview__img flex-col text-white">
            <svg
              width="40"
              height="40"
              viewBox="0 0 40 40"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M11.6667 16.6667V15C11.6667 10.3976 15.3976 6.66666 20 6.66666C24.6024 6.66666 28.3333 10.3976 28.3333 15V16.6667C32.0152 16.6667 35 19.6514 35 23.3333C35 25.8009 33.6593 28.014 31.6667 29.1667M11.6667 16.6667C7.98477 16.6667 5 19.6514 5 23.3333C5 25.8009 6.34066 28.014 8.33333 29.1667M11.6667 16.6667C12.3881 16.6667 13.0827 16.7812 13.7334 16.9932M20 20V35M20 20L25 25M20 20L15 25"
                stroke="white"
                stroke-width="2.5"
                stroke-linecap="square"
              />
            </svg>
            <span class="mt-1 text-center">
              {{ $t("Upload image") }}
            </span>
          </div>
        </label>
        <img :src="img" class="preview__img" alt="" v-if="img" />
        <img
          :src="defaultImage"
          class="preview__img"
          alt=""
          v-if="!img && defaultImage"
        />
        <div>
          <label class="photo-input__label" :class="this.$attrs.labelClass"
            >{{ $t(label) }}{{ $attrs.asterisk ? "*" : "" }}</label
          >
          <label
            v-if="img || defaultImage"
            class="photo-input__btn btn"
            :class="this.$attrs.labelClass"
            :for="id"
          >
            <svg
              width="28"
              height="28"
              viewBox="0 0 28 28"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M8.16667 11.6667V10.5001C8.16667 7.27842 10.7783 4.66675 14 4.66675C17.2217 4.66675 19.8333 7.27842 19.8333 10.5001V11.6667C22.4107 11.6667 24.5 13.7561 24.5 16.3334C24.5 18.0607 23.5615 19.6099 22.1667 20.4167M8.16667 11.6667C5.58934 11.6667 3.5 13.7561 3.5 16.3334C3.5 18.0607 4.43846 19.6099 5.83333 20.4167M8.16667 11.6667C8.67166 11.6667 9.15792 11.747 9.6134 11.8953M14 14.0001V24.5001M14 14.0001L17.5 17.5001M14 14.0001L10.5 17.5001"
                stroke="#063F5F"
                stroke-width="2.5"
                stroke-linecap="square"
              />
            </svg>
            {{ $t("Change picture") }}
          </label>
          <label
            v-if="img || defaultImage"
            class="photo-input__btn btn mt-4"
            :class="this.$attrs.labelClass"
            @click="remove"
          >
            <svg
              width="28"
              height="28"
              viewBox="0 0 28 28"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M11.668 11.6667V18.6667M16.3346 11.6667V18.6667M21.0013 7V21C21.0013 22.2887 19.9566 23.3333 18.668 23.3333H9.33464C8.04597 23.3333 7.0013 22.2887 7.0013 21V7M4.66797 7H23.3346M17.5013 7V5.83333C17.5013 4.54467 16.4566 3.5 15.168 3.5H12.8346C11.546 3.5 10.5013 4.54467 10.5013 5.83333V7"
                stroke="#063F5F"
                stroke-width="2.5"
                stroke-linecap="square"
              />
            </svg>

            {{ $t("Remove image") }}
          </label>
        </div>
        <input
          ref="file"
          type="file"
          :id="id"
          :accept="accept"
          class="hidden"
          @change="change"
        />
      </div>
    </div>
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
  <div class="image__croper--wrapper" v-if="showImageCroper">
    <div class="image__cropper">
      <div
        class="image__cropper--header mb-5 flex justify-between items-center"
      >
        <h3>{{ $t("Crop Image") }}</h3>
        <CloseIcon
          class="cursor-pointer"
          @click="showImageCroper = false"
        ></CloseIcon>
      </div>
      <div class="image__cropper--body">
        <cropper
          class="cropper"
          :src="img"
          :stencil-props="{
            aspectRatio: 10 / 10,
          }"
          ref="cropper"
        />
      </div>
      <div class="image__cropper--footer flex justify-center mt-1">
        <button
          class="btn btn-info crop-btn mt-2 w-[150px] btn-center"
          @click.prevent="crop"
        >
          {{ $t("Crop Image") }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { v4 as uuid } from "uuid";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";
import CloseIcon from "@/components/icons/CloseIcon.vue";
export default {
  components: { Cropper, CloseIcon },
  props: {
    modelValue: File | Blob,
    label: String,
    button_text: String,
    text: String,
    accept: {
      type: String,
      default: "image/png, image/jpeg, image/jpg",
    },
    error: {
      type: String,
      default: () => null,
    },
    id: {
      type: String,
      default() {
        return `text-input-${uuid()}`;
      },
    },
    croping: {
      type: Boolean,
      default: false,
    },
    defaultImage: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      img: null,
      showImageCroper: false,
    };
  },
  emits: ["update:modelValue", "changeFile", 'deleteImage'],
  watch: {
    modelValue(value) {
      if (!value) {
        this.$refs.file.value = "";
      }
    },
  },
  methods: {
    filesize(size) {
      var i = Math.floor(Math.log(size) / Math.log(1024));
      return (
        (size / Math.pow(1024, i)).toFixed(2) * 1 +
        " " +
        ["B", "kB", "MB", "GB", "TB"][i]
      );
    },
    browse() {
      this.$refs.file.click();
    },
    change(e) {
      const file = e.target.files[0];
      const reader = new FileReader();
      reader.onload = () => {
        this.img = reader.result;
        if (this.croping) {
          this.img = reader.result;
          this.showImageCroper = true;
        } else {
          this.$emit("update:modelValue", file);
          this.$emit("changeFile", reader.result);
        }
      };
      reader.readAsDataURL(file);
    },
    remove() {
      this.$emit("update:modelValue", null);
      this.$emit("changeFile", null);
      this.img = null;
      if (this.defaultImage) {
        this.$emit("deleteImage");
      }
    },
    crop() {
      const { coordinates, canvas } = this.$refs.cropper.getResult();
      canvas.toBlob((file) => {
        const dataUrl = canvas.toDataURL()
        this.$emit("update:modelValue", file);
        this.$emit("changeFile", dataUrl);
        this.img = dataUrl;
        this.showImageCroper = false;
      }, "image/jpeg");
    },
  },
};
</script>


<style lang="scss" scoped>
.preview__img {
  width: 105px;
  height: 105px;
  background: #063f5f;
  display: flex;
  align-items: center;
  justify-content: center;
}
.photo-input {
  position: relative;
  &__label {
    color: var(--Primary-Ball-Blue, #16a9b7);
    font-family: Poppins;
    font-size: 18px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
    margin-bottom: 12px;
    display: inline-block;
  }
  &__btn {
    display: flex;
    gap: 16px;
    align-items: center;

    color: var(--1-4, #2c5b7d);
    font-family: Nexa;
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;

    cursor: pointer;
  }
}

.image__croper--wrapper {
  background: rgba($color: #000000, $alpha: 0.2);
  width: 100%;
  height: 100%;
  display: block;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 9999;
}
.image__cropper {
  width: 530px;
  max-height: 630px;
  overflow: hidden;
  background: white;
  padding: 20px;
  border-radius: 10px;
  position: absolute;
  z-index: 999999;
  top: 110px;
  box-shadow: rgba(50, 50, 93, 0.1) 0px 7px 14px 0px,
    rgba(0, 0, 0, 0.08) 0px 3px 6px 0px;
  top: 100px;
  left: 50%;
  transform: translateX(-50%);

  &--body {
    max-height: 100%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }
}
</style>


<style lang="scss">
.vue-advanced-cropper.cropper {
  // max-width: 100%;
  // max-height: 100%;

  // .vue-advanced-cropper__background, .vue-advanced-cropper__foreground {
  //   max-width: 100%;
  //   max-height: 100%;
  //   overflow: hidden;
  // }
  .vue-advanced-cropper__stretcher {
    max-height: 500px !important;
  }
}


.crop-btn {
    border-radius: 8px;
    padding: 10px 12px;
    color: white;
}
</style>
