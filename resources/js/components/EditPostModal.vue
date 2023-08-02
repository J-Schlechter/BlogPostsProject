<template>
  <div class="modal is-active">
    <div class="modal-background" @click="$emit('close')"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Edit Post</p>
        <button class="delete" aria-label="close" @click="$emit('close')"></button>
      </header>
      <section class="modal-card-body">
        <div>
          <input v-model="editedPost.title" class="input" type="text" placeholder="Title" />
          <textarea v-model="editedPost.body" class="textarea" placeholder="Body"></textarea>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-success" @click="savePost">Save changes</button>
        <button class="button" @click="$emit('close')">Cancel</button>
      </footer>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  props: {
    post: {
      type: Object,
      required: true,
    },
  },
  setup(props, { emit }) {
    const editedPost = ref({ ...props.post });

    const savePost = () => {
      emit('save-post', editedPost.value);
      emit('close');
    };

    return {
      editedPost,
      savePost,
    };
  },
};
</script>

<style>
/* Your modal styles here if needed */
</style>
