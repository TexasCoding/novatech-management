<template>
    <div>
        <h4>View Categories</h4>
        <hr>

        <ul class="list-group">
            <li v-for="cat in categories" class="list-group-item">
                <input type="text" v-model="search">
                {{cat.category_path}}

                <form class="form-inline mt-3 mb-3" v-on:submit.prevent="submitForm">
                    <label for="ebidCat" class="mr-2">Ebid</label>
                    <input id="ebidCat" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0" type="text"
                           v-model="ebid_cat">

                    <label for="bonanzaCat" class="mr-2">Bonanza</label>
                    <input id="bonanzaCat" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0" type="text"
                           v-model="bonanza_cat">
                    <button class="btn btn-sm btn-primary">Save</button>
                </form>


                <ul class="list-group">
                    <li class="list-group-item  list-group-item-success"><h5>Bonanza Categories</h5></li>
                    <li v-for="bon in filteredBonanza" class="list-group-item list-group-item-action">
                        {{bon.category_path}}
                        <button class="btn btn-sm btn-default float-right" @click="setBonanza(bon.category_id)">Add</button>
                    </li>
                </ul>
                <ul class="list-group mt-5">
                    <li class="list-group-item list-group-item-info"><h5>Ebid Categories</h5></li>
                    <li v-for="ebid in filteredEbid" class="list-group-item  list-group-item-action">
                        {{ebid.category_path}}
                        <button class="btn btn-sm btn-default float-right" @click="setEbid(ebid.category_id)">Add</button>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</template>
<script>
    import axios from 'axios';

    export default {
        mounted() {
            this.getBonanzaCategories();
            this.getEbidCategories();
            this.getCategory();
        },
        computed: {
            filteredEbid() {
                return this.ebidCats.filter(item => {
                    return item.category_path.toLowerCase().indexOf(this.search.toLowerCase()) > -1
                })
            },
            filteredBonanza() {
                return this.bonanzaCats.filter(item => {
                    return item.category_path.toLowerCase().indexOf(this.search.toLowerCase()) > -1
                })
            }
        },
        methods: {
            submitForm() {
              this.setCategories();
            },
            setBonanza(value) {
                this.bonanza_cat = value;
            },
            setEbid(value) {
                this.ebid_cat = value;
            },
            getCategory() {
                const self = this;
                axios.get('http://novatech.test/api/categories/get')
                    .then(response => {
                        self.categories = response.data;
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getEbidCategories() {
                const self = this;
                axios.get('http://novatech.test/api/ebid_categories/get')
                    .then(response => {
                        self.ebidCats = response.data.data;
                        console.log(response.data.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getBonanzaCategories() {
                const self = this;
                axios.get('http://novatech.test/api/bonanza_categories/get')
                    .then(response => {
                        self.bonanzaCats = response.data.data;
                        console.log(response.data.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            setCategories() {
                const self = this;
                axios.post('http://novatech.test/api/categories/set', {
                    'category_id': self.categories.category.id,
                    'ebid_category': self.ebid_cat,
                    'bonanza_category': self.bonanza_cat
                })
                    .then(response => {
                        console.log(response.data);
                        self.ebid_cat = 0;
                        self.bonanza_cat = 0;
                        self.getCategory();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        data() {
            return {
                categories: [],
                ebidCats: [],
                bonanzaCats: [],
                bonanza_cat: 0,
                cat_id: 0,
                ebid_cat: 0,
                search: '---',
            }
        }
    }
</script>