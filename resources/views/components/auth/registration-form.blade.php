<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-6 center-screen">
            <div class="card animated fadeIn w-100 p-3 mt-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-12 p-2">
                                <label>Name</label>
                                <input id="name" placeholder="Your Name" class="form-control" type="text" />
                            </div>

                            <div class="col-12 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email" />
                            </div>

                            <div class="col-12 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password" />
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-12 p-2">
                                <button onclick="onRegistration()"
                                    class="btn mt-3 w-100  bg-gradient-primary">Registration</button>
                            </div>
                        </div>
                        <hr />
                        <div class="float-end mt-3">
                            <span>                                
                                <a class="text-center ms-3 h6" href="{{url('/loginPage')}}">Login</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function onRegistration() {
        let name = document.getElementById('name').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        if (name.length === 0) {
            errorToast('Name is required');
        } else if (email.length === 0) {
            errorToast('Email is required');
        } else if (password.length === 0) {
            errorToast('Password is required');
        }
        else {
            showLoader();
            let res = await axios.post("/userRegistration", {
                name: name,
                email: email,
                password: password
            });
            hideLoader();

            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['message']);
                setTimeout(function () {
                    window.location.href = "/loginPage";
                }, 200);
            } else {
                errorToast(res.data['message']);
            }
        }
    }
</script>