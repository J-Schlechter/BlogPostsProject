<template>
    <div id="modal-js-newPost" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
          <div class="box">
            <form method="POST" @submit.prevent="newPost">
                <div class="field">
      
                    <input class="input pb-2" type="text" id="title" name="title" placeholder="Your post's title" style="width: 70%" required>
                </div>
            
                <div class="field">
                    <textarea class="textarea" id="body" name="body" placeholder="Write your post here!" style="width: 65%" required></textarea>
                </div>

                <button class="button is-success">Save</button>
            </form>
          </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default{
    data() {
        return {
            categories : null,
            fields:   []
        };
    },
    methods: {
        newPost(){
            axios.post('newPost', this.fields).then(function name(response) {
                console.log(response)
                console.log('Error')
            });
        }
    }

};
</script>