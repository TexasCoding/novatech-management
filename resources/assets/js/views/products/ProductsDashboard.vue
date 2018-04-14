<template>
    <div>
        <h2>Dashboard -
            <small>Available Products: ({{productCount}})</small>
        </h2>
        <div>

            <div class="row">
                <div class="col-md-4">
                    <ebid-export-component></ebid-export-component>
                </div>
                <div class="col-md-4">
                    <bonanza-export-component></bonanza-export-component>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    import BonanzaExportComponent from '../../components/BonanzaExportComponent';
    import EbidExportComponent from '../../components/EbidExportComponent';

    export default {
        components: {BonanzaExportComponent, EbidExportComponent},
        comments: {
            BonanzaExportComponent,
            EbidExportComponent,
        },
        mounted() {
            this.getProductCount();
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
        },
        data() {
            return {
                productCount: 0,
            }

        }
    }
</script>