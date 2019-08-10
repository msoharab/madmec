<!-- Menu -->
<nav class="menu" id="theMenu">
    <div class="menu-wrap">
        <h1 class="logo"><a href="#home">Dashboard</a></h1>
        <i class="icon-remove menu-close"></i>
        <a href="#home" class="smoothScroll">Home</a>
        <a href="#about" class="smoothScroll">Job Post</a>
        <a href="#portfolio" class="smoothScroll">Blog</a>
        <a href="<?php echo URL.'admin/inc/';?>users.php" class="smoothScroll">Users</a>
        <a href="<?php echo URL ;?>" class="smoothScroll">Website</a>
        <a href="<?php echo URL.'html/';?>logout.php" class="smoothScroll">Logout</a>
        <a href="#"><i class="icon-facebook"></i></a>
        <a href="#"><i class="icon-twitter"></i></a>
        <a href="#"><i class="icon-dribbble"></i></a>
        <a href="#"><i class="icon-envelope"></i></a>
    </div>
    <!-- Menu button -->
    <div id="menuToggle"><i class="icon-reorder"></i></div>
</nav>
<!-- ========== HEADER SECTION ========== -->
<section id="home"></section>
<div id="headerwrap" style="background:url('assets/img/header-bg.jpg') no-repeat center top; background-size:cover; background-color: lightsteelblue">
    <div class="container">
        <div class="logo">
            <img src="assets/img/logo.png">
        </div>
        <br>
        <div class="row">
            <h1>MADMEC</h1>
            <br>
            <h3>ADMIN PANEL</h3>
            <br>
            <br>
            <div class="col-lg-6 col-lg-offset-3">
            </div>
        </div>
    </div>
    <!-- /container -->
</div>
<!-- /headerwrap -->
<!-- ========== ABOUT SECTION ========== -->
<section id="about"></section>
<div id="f" style="background:url('img/header-bg.jpg') no-repeat center top; background-size:cover; background-color: lightsteelblue">
    <div class="container">
        <div class="row">
            <h3>Job Post</h3>
            <p class="centered"><i class="icon icon-circle"></i><i class="icon icon-circle"></i><i class="icon icon-circle"></i></p>
            <!-- INTRO INFORMATIO-->
            <div class="col-lg-10 col-lg-offset-2">
                <div class="boxed-grey">
                    <form id="jobPostForm" name="jobPostForm" method="post" novalidate="novalidate">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="name">
                                        Job Title</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Job Title" required="required"/>
                                </div>
                                <div class="col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label for="Industry">
                                            Industry</label>
                                        <input type="text" name="industry" id="industry" class="form-control" placeholder="Industry" required="required"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="Employee">
                                            Employee Type</label>
                                        <select name="EmployeeTY" id="EmployeeTY" class="form-control" required="required"/>
                                        <option>Apprentices</option>
                                        <option>Casual</option>
                                        <option>Contract</option>
                                        <option>Fixed term</option>
                                        <option>Full-time</option>
                                        <option>Part-time</option>
                                        <option>Trainees</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label for="Experience">
                                            Experience</label>
                                        <input type="text" name="experience" id="experience" class="form-control"  placeholder="Experience" required="required"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="doj">
                                            Date of Joining</label>
                                        <input type="text" name="doj" id="doj" class="form-control" required="required"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Responsibilities">
                                        Responsibilities</label>
                                    <textarea name="responsibilities" id="responsibilities" class="form-control" rows="1" cols="25" required="required"
                                              placeholder="Responsibilities"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="Skills">
                                        Skills</label>
                                    <textarea name="skills" id="skills" class="form-control" rows="2" cols="25" required="required"
                                              placeholder="Skills"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="Description">
                                        Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="2" cols="25" required="required"
                                              placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary btn-lg" id="jobPostbtn" name="jobPostbtn">Post a Job</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /container -->
</div>
<!-- /f -->
<!-- ========== CAROUSEL SECTION ========== -->
<section id="portfolio"></section>
<div id="f">
    <div class="container">
        <div class="row centered">
            <h3>Write A Blog</h3>
            <p class="centered"><i class="icon icon-circle"></i><i class="icon icon-circle"></i><i class="icon icon-circle"></i></p>
            <div class="col-lg-12">
                <div class="boxed-grey">
                    <form id="blogform" name="blogform" method="post" action="">
                        <div class="row">
                            <div class="col-md-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label for="name">
                                        Blog Title</label>
                                    <input type="text" name="blogtitle" id="blogtitle" class="form-control" placeholder="Blog Title" required="required" />
                                </div>
                                <div class="form-group">
                                    <input type="file" name="blogimage" id="blogimage" class="form-control" required="required" />
                                </div>
                                <div class="form-group">
                                    <label for="desc">
                                        Description</label>
                                    <textarea name="blogdesc" id="blogdesc" class="form-control" rows="9" cols="25" required="required"
                                              placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" id="blogbtn" name="blogbtn" class="btn btn-primary btn-lg">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
