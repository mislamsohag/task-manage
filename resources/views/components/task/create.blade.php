<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label mt-2">Name</label>
                                <input id="name" type="text" class="form-control">

                                <label class="form-label mt-2">Description</label>
                                <input id="desc" type="text" class="form-control">                               

                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Image</label>
                                <input id="tImg" oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control">

                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>

    async function Save() {
        
        let taskName = document.getElementById('name').value;
        let description = document.getElementById('desc').value;        
        let taskImg = document.getElementById('tImg').files[0];

        if(taskName.length===0){
            errorToast("Name Required !")
        }
        else if(description.length===0){
            errorToast("Description Required !")
        }        
        else if(!taskImg){
            errorToast("Image Required !")
        }

        else {

            document.getElementById('modal-close').click();

            let formData=new FormData();
            formData.append('img',taskImg)
            formData.append('task_name',taskName)
            formData.append('description',description) 

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/taskCreate",formData,config)
            hideLoader();

            if(res.status===201){
                successToast('Request completed');
                document.getElementById("save-form").reset();
                await TaskList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }
</script>
