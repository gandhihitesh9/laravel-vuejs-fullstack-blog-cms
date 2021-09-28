<template>
    <div>
        <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Categories <Button type="dashed" @click="addModel=true">Add Category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Category Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(category, i) in categories" :key="i" v-if="categories.length">
								<td>{{category.id}}</td>
								<td class="_table_name">{{category.categoryName}}</td>
								<td>{{category.created_at}}</td>
								<td>
									<button class="_btn _action_btn edit_btn1" type="button" @click="showEditModel(category, i)">Edit</button>
									<button class="_btn _action_btn make_btn1" type="button" @click="showDeletingModel(category, i)" :loading="category.isDeleting">Delete</button>
								</td>
							</tr>
								<!-- ITEMS -->

								


						</table>
					</div>
				
					<!-- Cateogy adding Model -->
					<Modal
						v-model="addModel"
						title="Add Category"
						:mask-closable="false"
						:closable="false"
						>
						<Input v-model="data.categoryName" placeholder="e.g. Birds" />
                        <div class="space"></div>
                        <Upload
                            multiple
                            type="drag"
                            action="//jsonplaceholder.typicode.com/posts/">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
						<div slot="footer">
							<Button type="default" @click="addModel=false">Close</Button>
							<Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{ isAdding ? "Adding...": "Add" }}</Button>
						</div>
					</Modal>

					<!-- Cateogy editing Model -->
					<Modal
						v-model="editModel"
						:title="`Edit Category - ${editData.categoryName}`"
                        :mask-closable="false"
						:closable="false"
						>
						<Input v-model="editData.categoryName" placeholder="e.g. Birds" />
						<div slot="footer">
							<Button type="default" @click="editModel=false">Close</Button>
							<Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{ isAdding ? "Editing...": "Edit" }}</Button>
						</div>
					</Modal>

					<!-- delete alert model  -->
					<Modal v-model="showDeleteModel" width="360">
						<p slot="header" style="color:#f60;text-align:center">
							<Icon type="ios-information-circle"></Icon>
							<span>Delete confirmation</span>
						</p>
						<div style="text-align:center">
							<p>Are you sure want to delete this record?</p>
							
						</div>
						<div slot="footer">
							<Button type="error" size="large" long :loading="isDeleing" :disabled="isDeleing" @click="deleteCategory">Delete</Button>
						</div>
					</Modal>


				</div>
				 
			</div>
		</div>
    </div>
</template>
<script>
export default {

	data(){
		return {
			data : {
				categoryName: '',
			},
			addModel: false,
			editModel: false,
			isAdding: false,
			categories: [],
			editData: {
				categoryName: '',
			},
			editIndex: -1,
			showDeleteModel: false,
			isDeleing : false,
			deletingIndex: -1,
			deleteItem: {},
			
		}
	},
	methods: {
		async addCategory() {
			if(this.data.categoryName.trim() == ""){
				return this.e("Oops!", "Category name field is required");
			}
			const addedCategoryRes = await this.callApi("post", 'app/category/create', this.data);
			
			if(addedCategoryRes.status === 201){
				this.categories.unshift(addedCategoryRes.data);
				this.s("Success!", "Category has been added");
				this.addModel = false;
				this.data.categoryName = "";
			}else{
				
				if(addedCategoryRes.status == 422){
					if(addedCategoryRes.data.errors.categoryName){
						this.e("Oops!", addedCategoryRes.data.errors.categoryName[0]);
					}
				}else{
					this.e("Oops!", addedCategoryRes.msg);
				}
				
			}
		},
		async editCategory() {
			if(this.editData.categoryName.trim() == ""){
				return this.e("Oops!", "Category Name field is required");
			}
			const editCategoryRes = await this.callApi("post", 'app/category/edit/', this.editData);
			
			if(editCategoryRes.status === 200){
				this.categories[this.editIndex].categoryName = editCategoryRes.data[0].categoryName;
				this.s("Success!", "Category name has been edited");
				this.editModel = false;
				this.editData.categoryName = "";
			}else{
				
				if(editCategoryRes.status == 422){
					if(editCategoryRes.data.errors.categoryName){
						this.e("Oops!", editCategoryRes.data.errors.categoryName[0]);
					}
				}else{
					this.e("Oops!", editCategoryRes.msg);
				}
				
			}
		},
		showEditModel(category, editIndex){
            console.log(category);
			this.editIndex = editIndex;
			let category_obj = {
				id: category.id,
				categoryName: category.categoryName,
			};
			//this.editData = category_obj;
			this.editData = category_obj;
			this.editModel = true;
		},
		async deleteCategory(){
			this.isDeleing = true;
			//if(!confirm("Are you sure want to delete this record?")) return
			//this.$set(tag, 'isDeleting', true);
			const deleteTagRes = await this.callApi("post", "app/tag/delete", this.deleteItem);
			if(deleteTagRes.status == 200){
				this.categories.splice(this.deletingIndex, 1);
				this.s("Success!", "Tag has been deleted");
			}else{
				this.e("Oops!", editTagRes.msg);	
			}
			this.isDeleing = false;
			this.showDeleteModel = false;
			
		},
		showDeletingModel(tag, i){
			/* const deleteModalObj = {
				showDeleteModel: true,
				showDeleteModel: true,
				deleteUrl: "app/tag/delete",
				data: tag,
				deletingIndex: i,
				isDeleted : false,
			};*/
			this.deleteItem = tag;
			this.deletingIndex = i;
			this.showDeleteModel = true;
		}
	},
 	async created(){
		 const getCategoryRes = await this.callApi("get", "app/category/index");
		 if(getCategoryRes.status == 200){
			 
			 this.categories = getCategoryRes.data;
		 }
	 }
	/* async created(){
		const res = await this.callApi('post', '/app/create_tag', {tagName: "testing"});
		console.log(res);
		if(res.status == 200){
			console.log(res);
		}else{
			console.log(res);
			console.log("not 200");
		}

	}*/
}
</script>