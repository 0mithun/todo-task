<template>
  <div class="status-wrapper">
    <div
      class="status"
      :style="styles"
      @mouseover="showTooltip"
      @mouseleave="hideTooltip"
      ref="statusElement"
    ></div>
    <div
      v-if="tooltipVisible"
      class="tooltip"
      :style="{
        top: `${tooltipPosition.top}px`,
        left: `${tooltipPosition.left}px`,
      }"
    >
      {{ $t(tooltipText) }}
    </div>
  </div>
</template>
<script>
export default {
  props: {
    company: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      status: this.company.status,
      tooltipVisible: false,
      tooltipPosition: { top: 0, left: 0 },
    };
  },
  computed: {
    styles() {
      let color = "";
      if (this.status == "active") {
        color = "55C5CD";
      } else if (this.status == 0) {
        color = "E97D32";
      } else {
        color = "063F5F";
      }

      return `background: #${color};`;
    },
    tooltipText() {
      return this.status === "active" ? "Active" : "Inactive";
    },
  },
  methods: {
    showTooltip(event) {
      const rect = this.$refs.statusElement.getBoundingClientRect();
      this.tooltipPosition = {
        top: rect.bottom + 30,
        left: rect.left + 40,
      };
      this.tooltipVisible = true;
    },
    hideTooltip() {
      this.tooltipVisible = false;
    },
  },
};
</script>

<style lang="scss" scoped>
.status-wrapper {
  position: relative;
  display: inline-block;
}
.status {
  position: relative;
  width: 14px;
  height: 14px;
}
.tooltip {
  position: fixed;
  background-color: #fff;
  color: #111;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 13px;
  white-space: nowrap;
  z-index: 1000;
  pointer-events: none;
  transform: translate(-50%, -100%);
}
</style>
