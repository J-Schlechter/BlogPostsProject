<template>
    <div>
    <div class="modal" :class="{ 'is-active': isActive }">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <button class="delete" aria-label="close" @click="cancel"></button>
        </header>
        <section class="modal-card-body">
          <p class="text has-text-black">Are you sure you want to delete this post?</p>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-danger" @click="confirm">Delete</button>
          <button class="button" @click="cancel">Cancel</button>
        </footer>
      </div>
    </div>
</div>
  </template>
  
  <script>
export default {
  props: {
    isActive: {
      type: Boolean,
      required: true,
    },
  },
  methods: {
    confirm() {
      this.$emit('confirmed');
    },
    cancel() {
      this.$emit('canceled');
    },
  },
};
</script>

  
  <style>
  /* Add your CSS styles for the ConfirmationModal.vue component */
  </style>
  