<template>
    <div>
        <h2>Dashboard - <small>Available Products: ({{productCount}})</small></h2>
        <div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Bonanza Products ({{bonanzaCount}})
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-block" @click="parseBonanza">Export Bonanza</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            eBid Products ({{ebidCount}})
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-block" @click="parseEbid">Export eBid</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import Papa from 'papaparse';

    export default {
        mounted() {
            this.getProductCount();
            this.getBonanzaCount();
            this.getEbidCount();
        },
        methods: {
            getProductCount() {
                const self = this;
                axios.get('http://novatech.test/api/products/inventory/count')
                    .then(response => {
                        self.productCount = response.data;
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
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
            parseBonanza() {
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
                        //console.log(self.csvData);

                    });
            },
            parseEbid() {
                const self = this;
                axios.get('http://novatech.test/api/ebid/products')
                    .then(response => {
                        self.csvData = response.data;
                        console.log(self.csvData);

                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        const csv = Papa.unparse(self.csvData, {
                            delimiter: '\t',
                        });
                        self.downloadCSV(csv, 'ebid.txt');
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
                productCount: 0,
                bonanzaCount: 0,
                ebidCount: 0,
            }

        }
    }
</script>