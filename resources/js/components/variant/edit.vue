<template>
  <div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              
              <div class="form-group">
                <label>Tên thuộc tính</label>
                <vs-input
                  type="text"
                  size="default"
                  placeholder="Tên thuộc tính"
                  class="w-100"
                  v-model="objData.name"
                />
              </div>
              <el-tag
                :key="tag"
                v-for="tag in objData.variant_value"
                closable
                :disable-transitions="false"
                @close="handleClose(tag)">
                {{tag}}
              </el-tag>
              <el-input
                class="input-new-tag"
                v-if="inputVisible"
                v-model="inputValue"
                ref="saveTagInput"
                size="mini"
                @keyup.enter.native="handleInputConfirm"
                @blur="handleInputConfirm"
              >
              </el-input>
              <el-button v-else class="button-new-tag" size="small" @click="showInput">+ Biến thể</el-button>
              <div class="form-group">
                <label>Trạng thái</label>
                <vs-select v-model="objData.status"
                  >
                      <vs-select-item  value="1" text="Hiện" />
                      <vs-select-item  value="0" text="Ẩn" />
                    </vs-select>
              </div>
            </div>
          </div>
          
        </div>
        
      </div>
      <div class="row fixxed">
        <div class="col-12">
          <div class="saveButton">
            <vs-button color="primary" @click="addVariants">Cập nhật</vs-button>
          </div>
        </div>
      </div>
    <!-- content-wrapper ends -->
  </div>
</template>


<script>
import { mapActions } from "vuex";
import TinyMce from "../_common/tinymce";
import { required } from "vuelidate/lib/validators";
import ImageMulti from "../_common/upload_image_multi";
export default {
  name: "editSolution",
  data() {
    return {
      showLang:{
        title:false,
        content:false,
        description:false
      },
        inputVisible: false,
        inputValue: "",
      errors:[],
      cate:[],
      type_cate:[],
      objData: {
        id: this.$route.params.id,
        name: "",
        status: 1,
        variant_value:[]
      },
      lang:[]
    };
  },
  components: {
    TinyMce,ImageMulti
  },
  computed: {},
  watch: {},
  methods: {
    ...mapActions(["addVariant", "loadings","detailVariant","listLanguage"]),
    handleClose(tag) {
        this.objData.variant_value.splice(this.objData.variant_value.indexOf(tag), 1);
      },

      showInput() {
        this.inputVisible = true;
        this.$nextTick(_ => {
          this.$refs.saveTagInput.$refs.input.focus();
        });
      },

      handleInputConfirm() {
        let inputValue = this.inputValue;
        if (inputValue) {
          this.objData.variant_value.push(inputValue);
        }
        this.inputVisible = false;
        this.inputValue = "";
      },
    addVariants(){
      this.errors = [];
      if(this.objData.name == '') this.errors.push('Tên không được để trống');
      if (this.errors.length > 0) {
        this.errors.forEach((value, key) => {
          this.$error(value)
        })
        return;
      }else{
        this.loadings(true);
        this.addVariant(this.objData).then(response => {
          this.loadings(false);
          this.$router.push({name:'list_variant'});
          this.$success('Thành công');
        }).catch(error => {
          this.loadings(false);
          this.$error('Thất bại');
        })
      }
    },
    editById() {
      this.loadings(true);
      this.detailVariant({id:this.$route.params.id}).then(response => {
        this.loadings(false);
          this.objData = response.data;
          this.objData.variant_value = response.variant_value
      }).catch(error => {
        console.log(12);
      });
    },
    listLang(){
      this.listLanguage().then(response => {
        this.lang  = response.data
      }).catch(error => {

      })
    },
    changeLanguage(data){
      this.editById();
    }
  },
  mounted() {
    this.editById();
    this.listLang();
  }
};
</script>
<style>
  .el-tag + .el-tag {
    margin-left: 10px;
  }
  .button-new-tag {
    margin-left: 10px;
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
  }
  .input-new-tag {
    width: 90px;
    margin-left: 10px;
    vertical-align: bottom;
  }
</style>
