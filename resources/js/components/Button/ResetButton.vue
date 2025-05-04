<template>
  <button>
    <span class="icon">
      <slot name="icon"></slot>
    </span>
    <span class="text">
      <slot name="text">
        {{ $t("Reset") }}
      </slot>
    </span>
  </button>
</template>

<style lang="scss" scoped>
button {
  display: flex;
  width: auto;
  height: 38px;
  padding: 4px 30px;
  justify-content: center;
  align-items: center;
  border-radius: 8px;
  background: #eef1f1;
  color: #4d5a5c;
  font-family: Poppins;
  font-size: 13px;
  font-style: normal;
  font-weight: 600;
  line-height: normal;
}
</style>
