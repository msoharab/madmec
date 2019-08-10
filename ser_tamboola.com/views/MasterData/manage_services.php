<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#list1" data-toggle="tab">List</a></li>
        <!--<li><a href="#add1" data-toggle="tab">Add</a></li>-->
    </ul>
    <div class="tab-content">
        <div class="active tab-pane" id="list1">
            <?php
            require_once 'services_list.php';
            ?>
        </div>
        <div class="tab-pane" id="add1">
            <?php
            require_once 'services.php';
            ?>
        </div>
    </div>
</div>
