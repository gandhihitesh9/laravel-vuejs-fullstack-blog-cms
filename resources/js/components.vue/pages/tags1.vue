<template>
    <div>

        <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button type="dashed" @click="addModel=true">Add Tag</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tag Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
								<td>{{tag.id}}</td>
								<td class="_table_name">{{tag.tagName}}</td>
								<td>{{tag.created_at}}</td>
								<td>
									<button class="_btn _action_btn edit_btn1" type="button" @click="showEditModel(tag, i)">Edit</button>
									<button class="_btn _action_btn make_btn1" type="button" @click="showDeletingModel(tag, i)" :loading="tag.isDeleting">Delete</button>
								</td>
							</tr>
								<!-- ITEMS -->

								


						</table>
					</div>
				
					<!-- Tag adding Model -->
					<Modal
						v-model="addModel"
						title="Add Tag"
						:mask-closable="false"
						:closable="false"
						>
						<Input v-model="data.tagName" placeholder="e.g. Birds" />
						<div slot="footer">
							<Button type="default" @click="addModel=false">Close</Button>
							<Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? "Adding...": "Add" }}</Button>
						</div>
					</Modal>

					<!-- Tag editing Model -->
					<Modal
						v-model="editModel"
						title="Edit Tag"
						:mask-closable="false"
						:closable="false"
						>
						<Input v-model="editData.tagName" placeholder="e.g. Birds" />
						<div slot="footer">
							<Button type="default" @click="editModel=false">Close</Button>
							<Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? "Editing...": "Edit" }}</Button>
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
							<Button type="error" size="large" long :loading="isDeleing" :disabled="isDeleing" @click="deleteTag">Delete</Button>
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
				tagName: '',
			},
			addModel: false,
			editModel: false,
			isAdding: false,
			tags: [],
			editData: {
				tagName: '',
			},
			editIndex: -1,
			showDeleteModel: false,
			isDeleing : false,
			deletingIndex: -1,
			deleteItem: {},
			
		}
	},
	methods: {
		async addTag() {
			if(this.data.tagName.trim() == ""){
				return this.e("Oops!", "Tag name field is required");
			}
			const addedTagRes = await this.callApi("post", 'app/tag/create', this.data);
			
			if(addedTagRes.status === 201){
				this.tags.unshift(addedTagRes.data);
				this.s("Success!", "Tag name is added");
				this.addModel = false;
				this.data.tagName = "";
			}else{
				
				if(addedTagRes.status == 422){
					if(addedTagRes.data.errors.tagName){
						this.e("Oops!", addedTagRes.data.errors.tagName[0]);
					}
				}else{
					this.e("Oops!", addedTagRes.msg);
				}
				
			}
		},
		async editTag() {
			if(this.editData.tagName.trim() == ""){
				return this.e("Oops!", "Tag name field is required");
			}
			const editTagRes = await this.callApi("post", 'app/tag/edit/', this.editData);
			
			if(editTagRes.status === 200){
				this.tags[this.editIndex].tagName = editTagRes.data[0].tagName;
				this.s("Success!", "Tag name has been edited");
				this.editModel = false;
				this.editData.tagName = "";
			}else{
				
				if(editTagRes.status == 422){
					if(editTagRes.data.errors.tagName){
						this.e("Oops!", editTagRes.data.errors.tagName[0]);
					}
				}else{
					this.e("Oops!", editTagRes.msg);
				}
				
			}
		},
		showEditModel(tag, editIndex){
			this.editIndex = editIndex;
			let tag_obj = {
				id: tag.id,
				tagName: tag.tagName,
			};
			//this.editData = tag;
			this.editData = tag_obj;
			this.editModel = true;
		},
		async deleteTag(){
			this.isDeleing = true;
			//if(!confirm("Are you sure want to delete this record?")) return
			//this.$set(tag, 'isDeleting', true);
			const deleteTagRes = await this.callApi("post", "app/tag/delete", this.deleteItem);
			if(deleteTagRes.status == 200){
				this.tags.splice(this.deletingIndex, 1);
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
		 const getTagsRes = await this.callApi("get", "app/tag/index");
		 if(getTagsRes.status == 200){
			 
			 this.tags = getTagsRes.data;
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