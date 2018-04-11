<template>
    <div>
        <h2>Export Bonanza</h2>
        <div>
            <button class="btn btn-primary" @click="parseBonanza">Export Bonanza</button>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import Papa from 'papaparse';

    export default {
        mounted() {
            // this.getProductCount();
        },
        methods: {
            getBonanzaProducts() {
                const self = this;
                axios.get('http://novatech.test/api/products/inventory/count')
                    .then(response => {
                        self.productCount = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            parseBonanza(){
                const self = this;
                axios.get('http://novatech.test/api/products/bonanza/get')
                    .then(response => {
                        self.csvData = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        const csv = Papa.unparse(self.csvData.data);
                        self.downloadCSV(csv, 'bonanza.csv');
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
                csvData: {},
            }

        }
    }
</script>