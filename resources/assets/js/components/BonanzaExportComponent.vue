<template>
    <div class="card">
        <div class="card-header">
            Bonanza Products ({{bonanzaCount}})
        </div>
        <div class="card-body">
            <button v-if="!bonanzaDownloading" class="btn btn-primary btn-block" @click="parseBonanza">Export Bonanza</button>
            <button v-if="bonanzaDownloading" class="btn btn-primary btn-block disabled" disabled><font-awesome-icon :icon="spinner" spin/> Downloading...</button>
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
            this.getBonanzaCount();
        },
        methods: {
            getBonanzaCount() {
                const self = this;
                axios.get('http://novatech.test/api/bonanza/products/count')
                    .then(response => {
                        self.bonanzaCount = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            parseBonanza() {
                this.bonanzaDownloading = true;
                const self = this;
                axios.get('http://novatech.test/api/bonanza/products')
                    .then(response => {
                        self.csvData = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        const csv = Papa.unparse(self.csvData);
                        self.downloadCSV(csv, 'bonanza.csv');
                        self.bonanzaDownloading = false;
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
                bonanzaCount: 0,
                bonanzaDownloading: false,
            }

        }
    }
</script>