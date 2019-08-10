<style>
	#member_form input{color:#23793b;}
</style> <form method="POST" id="member_form" onmouseover="show_form();" onmouseout="dim_form();">
            <fieldset>
                <div class="form-group">
                    <input onkeypress="javascript:checkNumber();" class="form-control" placeholder="9900000000" name="mobile" type="number" id="mobile" value="" minlength="10" />
                    <span class="danger" id="mobile_err" style="color:#F44336;display:none;">Mobile number already registered, Please type other number</span>
                </div>
                <div class="form-group">
                        <input onkeypress="javascript:checkNumber();" class="form-control" placeholder="Name" name="name" type="name" id="name" minlength="3"/>
                </div>

                <div class="checkbox" align="left">
                    <label>
                        <input type="checkbox" name="more_details" id="more_detail_check" value="yes" onclick="javascript:addMoreDetails();">
                        <a href="javascript:void();" onclick="javascript:void(0);"><strong>Add More Details</strong></a>
                    </label>
                </div>
                <div id="more_details" style="display: none;">

                        <div class="form-group">
                                <input class="form-control" placeholder="Email" name="email" type="email" id="email" />
                        </div>
                        <div class="form-group">
                                <input class="form-control" placeholder="01-01-1989" name="dob" type="text" id="dob" />
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="gender" id="gender" >
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                                <input class="form-control" placeholder="zipcode" name="zipcode" type="text" id="zipcode" />
                        </div>
                        <div class="form-group">
                                <input class="form-control" placeholder="Address" name="address" type="text" id="address" />
                        </div>
                        <div class="form-group">
                                <input class="form-control" placeholder="Frazer Town" name="locality" type="text" id="locality" />
                        </div>
                        <div class="form-group">
                                <select class="form-control" name="city"  id="city" maxlength="10" />
                                    <option value="Bangalore">Bangalore</option>
                                    <option value="Hyderabad">Hyderabad</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <select class="form-control" name="province"  id="province" maxlength="10" />
                                    <option value="Bangalore">Karnataka</option>
                                    <option value="Hyderabad">Andra</option>
                                </select>
                        </div>
                </div>
                <button class="btn btn-lg btn-danger btn-block" href="javascript:void(0);" id="submit"><i class="fa fa-sign-in fa-fw fa-2x"></i> &nbsp;SUBMIT</button>
        </fieldset>
 </form>