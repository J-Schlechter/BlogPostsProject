<template>
    <button class="js-modal-trigger button is-danger" data-target="modal-js-newPost">
                

    </button>

    <div id="modal-js-newPost" class="modal">
        <div class="modal-background"></div>
    
        <div class="modal-content">
          <div class="box">
            <form>
                <div class="field">
      
                    <input class="input pb-2" type="text" id="title" name="title" placeholder="Your post's title" style="width: 70%" required>
                </div>
            
                <div class="field">
                    <textarea class="textarea" id="body" name="body" placeholder="Write your post here!" style="width: 65%" required></textarea>
                </div>
            </form>
          </div>
        </div>
    </div>
</template>

<script>
export default{
    data() {
        return {
            'Post':{
                'title':'',
                'body':''
            }
        };
    },

};
</script>