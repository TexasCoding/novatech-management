<template>
    <div>
        <h2>Dashboard</h2>
        <div>
            Available Products: {{productCount}}
            <p>
                <button class="btn btn-primary" @click="parseBonanza">Export Bonanza</button>
            </p>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import Papa from 'papaparse';

    export default {
        mounted() {
            this.getProductCount();
        },
        methods: {
            getProductCount() {
                const self = this;
                axios.get('http://novatech.test/api/products/inventory/count')
                    .then(response => {
                        self.productCount = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getBonanzaProducts() {
                const self = this;
                axios.get('http://novatech.test/api/products')
                    .then(response => {
                        self.productCount = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            parseBonanza(){
                const self = this;
                axios.get('http://novatech.test/api/products')
                    .then(response => {
                        self.csvData = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        const csv = Papa.unparse(self.csvData);
                        self.downloadCSV(csv, 'bonanza.csv');
                        //console.log(self.csvData);

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
                productCount: 0
            }

        }
    }
</script>