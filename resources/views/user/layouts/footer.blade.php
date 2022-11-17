
<div class="modal fade" id="HeaderChangePasswordModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-validation">
                    <h4 class="card-title text-left">Change Password</h4>
                    <form class="form-valide" action="" mathod="POST" id="change_pwd_form" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12 mb-2 mb-xl-3 text-left">
                                <label class="col-form-label" for="name">New Password</label>
                                <div class="">
                                    <input type="password" class="form-control new_password" id="new_password" value="" name="new_password" placeholder="New Password">
                                    <div id="new_password-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-2 mb-xl-3 text-left">
                                <label class="col-form-label" for="name">Confirm Password</label>
                                <div class="">
                                    <input type="password" class="form-control confirm_new_password" id="confirm_new_password" value="" name="confirm_new_password" placeholder="Confirm New Password">
                                    <div id="confirm_new_password-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" id="save_newAttrBtn">Submit</button>
                            </div>
                            <span id="loader">
                                <div class="loader">
                                    <svg class="circular" viewBox="25 25 50 50">
                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                    </svg>
                                </div>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary delete" id="RemoveUserSubmit">Delete</button>
            </div> -->
        </div>
    </div>
</div>

<div class="copyright">
    <p>Copyright &copy; Web Wedant Technology by <a href="https://webvedantinfotech.com/"></a> 2022</p>
</div>