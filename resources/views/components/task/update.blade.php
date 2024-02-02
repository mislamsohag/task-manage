<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Task Update</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">


                                

                                <label class="form-label mt-2">Task Name</label>
                                <input id="taskName" type="text" class="form-control">

                                <label class="form-label mt-2">Description</label>
                                <input id="description" type="text" class="form-control">

                                <br/>
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>
                                <label class="form-label mt-2">Image</label>
                                <input id="taskImg" oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">

                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>

        </div>
    </div>
</div>


<script>    

    async function FillUpUpdateForm(id, filePath){
        document.getElementById('updateID').value=id;
        document.getElementById('filePath').value=filePath;
        document.getElementById('oldImg').src=filePath;


        showLoader(); 
        let res=await axios.post("/singleTask",{id:id});
        hideLoader();
        console.log(res);

        document.getElementById('taskName').value=res.data['task_name'];
        document.getElementById('description').value=res.data['description'];
    }



    async function update() {
        
        let taskNameUpdate = document.getElementById('taskName').value;
        let descriptionUpdate = document.getElementById('description').value;
        let taskImgUpdate = document.getElementById('taskImg').files[0];
        let updateID=document.getElementById('updateID').value;
        let filePath=document.getElementById('filePath').value;


        if(taskNameUpdate.length===0){
            errorToast("Task Name Required !")
        }
        else if(descriptionUpdate.length===0){
            errorToast("Description Required !")
        }       

        else {
            document.getElementById('update-modal-close').click();

            let formData=new FormData();
            formData.append('img',taskImgUpdate)
            formData.append('task_name',taskNameUpdate)
            formData.append('description',descriptionUpdate)
            formData.append('id',updateID)
            formData.append('file_path',filePath)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/taskUpdate", formData, config)
            hideLoader();

            if(res.status===200 && res.data===1){
                successToast('Request completed');
                document.getElementById("update-form").reset();
                await TaskList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }
</script>
