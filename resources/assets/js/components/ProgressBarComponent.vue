<template id="progress-bar">
    <div class="progress">
        <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" :style="{width: getProgress}">
      <span v-if="progress < 100 && showProgressText">
      {{getProgress}}
      </span>
            <span v-if="progress >= 100 && showProgressText">{{progressCompleteText}}</span>
        </div>
    </div>
</template>
<script>
    export default {
        template: '#progress-bar-component',
        props: {
            progress: {
                default: 0,
                type: Number
            },
            showProgressText: {
                default: true,
                type: Boolean
            },
            progressCompleteText: {
                default: 'Complete!',
                type: String
            }
        },
        computed: {
            getProgress() {
                return Math.round(this.progress) + "%";
            }
        },
        watch: {
            progress(progress) {
                this.currentProgress = progress;
            }
        },
        data() {
            return {
                currentProgress: 0
            }
        }
    }
</script>