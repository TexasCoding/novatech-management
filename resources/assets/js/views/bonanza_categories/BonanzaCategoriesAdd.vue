<template>
    <div>
        <h4>Add Bonanza Categories</h4>
        <hr>
        <p v-if="!hideForm">
            <button type="button" class="btn btn-info">
                Uploads <span class="badge badge-light">{{successCount}}</span>
            </button>
            <button type="button" class="btn btn-warning float-right">
                Errors <span class="badge badge-light">{{errorCount}}</span>
            </button>
        </p>
        <progress-bar-component :progress="progress" v-if="!hideForm"></progress-bar-component>

        <form v-on:submit.prevent="submitForm" v-if="hideForm">
            <div class="form-group">
                <label for="inventoryCSV">Bonanza Category CSV</label>
                <input
                        type="file"
                        class="form-control-file"
                        id="inventoryCSV"
                        name="inventoryCSV"
                        @change="processFile($event)">
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>
<script>
    import Papa from 'papaparse';
    import axios from 'axios';
    import ProgressBarComponent from '../../components/ProgressBarComponent';

    export default {
        components: {
            ProgressBarComponent
        },
        methods: {
            processFile(event) {
                this.csvsFile = event.target.files[0];
            },
            submitForm() {
                this.parseFile();
            },
            parseFile() {
                const self = this;
                self.hideForm = false;
                Papa.parse(this.csvsFile, {
                    header: true,
                    // preview: 50,
                    step(results, parser) {

                        parser.pause();
                        axios
                            .post('http://novatech.test/api/bonanza_categories/add', [{
                                'category_path': results.data[0]['Full Name'],
                                'category_id': results.data[0]['Category ID']
                            }])
                            .then(response => {
                                self.successCount += 1;
                                console.log(response);
                            })
                            .catch(error => {
                                self.errorCount += 1;
                                console.log(error);
                            })
                            .finally(() => {
                                parser.resume();

                            });

                        self.progress = (self.successCount + self.errorCount) * (100 / self.totalCount);
                        if (self.progress >= 100) self.hideForm = true;
                    }
                });

            },
        },
        data() {
            return {
                progress: 0,
                successCount: 0,
                errorCount: 0,
                totalCount: 20126,
                hideForm: true,
            }
        }
    }
</script>