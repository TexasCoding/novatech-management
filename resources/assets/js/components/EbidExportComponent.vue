<template>
    <div class="card">
        <div class="card-header">
            eBid Products ({{ebidCount}})
        </div>
        <div class="card-body">
            <button v-if="!ebidDownloading" class="btn btn-primary btn-block" @click="parseEbid">Export eBid</button>
            <button v-if="ebidDownloading" class="btn btn-primary btn-block disabled" disabled>
                <font-awesome-icon :icon="spinner" spin/>
                Downloading...
            </button>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import Papa from 'papaparse';

    import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
    import faSpinner from '@fortawesome/fontawesome-free-solid/faSpinner';

    export default {

        computed: {
            spinner() {
                return faSpinner
            }
        },
        components: {
            FontAwesomeIcon,
        },

        mounted() {
            this.getEbidCount();
        },
        methods: {
            getEbidCount() {
                const self = this;
                axios.get('http://novatech.test/api/ebid/products/count')
                    .then(response => {
                        self.ebidCount = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            parseEbid() {
                this.ebidDownloading = true;
                const self = this;
                axios.get('http://novatech.test/api/ebid/products')
                    .then(response => {
                        self.csvData = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        const csv = Papa.unparse(self.csvData, {
                            delimiter: '\t',
                            header: false,
                        });
                        self.downloadCSV(csv, 'ebid.txt');
                        self.ebidDownloading = false;
                    });

            },
            downloadCSV(csv, file) {
                const blob = new Blob([csv]);
                const a = window.document.createElement('a');
                a.href = window.URL.createObjectURL(blob, {type: 'text/plain'});
                a.download = file;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            },
        },
        data() {
            return {
                ebidCount: 0,
                ebidDownloading: false,
            }
        }
    }
</script>