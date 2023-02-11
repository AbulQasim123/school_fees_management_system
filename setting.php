<?php
    include('database_connection.php');

    if (!is_login()) {
        header('location:login.php');
    }
    if (!is_master_user()) {
        header('location:index.php');
    }

    $message = '';
    $error = '';
    $setting_id = '';
    $school_name = '';
    $school_address = '';
    $school_email_address = '';
    $school_website = '';
    $school_contact_number = '';

    if (isset($_POST['setting_user'])) {
        $formdata = array();

        if (empty($_POST['school_name'])) {
            $error .= 'School Name is Required?';
        }else{
            $formdata['school_name'] = trim($_POST['school_name']);
        }

        if (empty($_POST['school_address'])) {
            $error .= 'School Address is Required?';
        }else{
            $formdata['school_address'] = trim($_POST['school_address']);
        }

        if (empty($_POST['school_email_address'])) {
            $error .= 'School Email Address is Required?';
        }else{
            if (!filter_var($_POST['school_email_address'], FILTER_VALIDATE_EMAIL)) {
                $error .= 'School Email Address is Invalid!';  
            }else{
                $formdata['school_email_address'] = trim($_POST['school_email_address']);
            }
        }

        if (empty($_POST['school_website'])) {
            $error .= 'School Website is Required?';
        }else{
            if (!filter_var($_POST['school_website'], FILTER_VALIDATE_URL)) {
                $error .= 'School Website Address is Invalid!';  
            }else{
                $formdata['school_website'] = trim($_POST['school_website']);
            }
        }

        if (empty($_POST['school_contact_number'])) {
            $error .= 'School Contact Number is Required?';
        }else{
            $formdata['school_contact_number'] = trim($_POST['school_contact_number']);
        }

        if ($error == '') {
            $data = array(
                ':school_name' => $formdata['school_name'],
                ':school_address' => $formdata['school_address'],
                ':school_email_address' => $formdata['school_email_address'],
                ':school_website' => $formdata['school_website'],
                ':school_contact_number' => $formdata['school_contact_number'],
            );

            if ($_POST['setting_id'] == '') {
                $query = "INSERT INTO sfms_setting (school_name,school_address,school_email_address,school_website,school_contact_number) VALUES (:school_name,:school_address,:school_email_address,:school_website,:school_contact_number)";
            }else{
                $query = "UPDATE sfms_setting SET school_name = :school_name, school_address = :school_address, school_email_address = :school_email_address, school_website = :school_website, school_contact_number = :school_contact_number";
            }

            $statement = $connect->prepare($query);
            $statement->execute($data);
            $message = '<div class="alert alert-success alert-dismissible fade show">Data Successfully Changed<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
    }


    $query = "SELECT * FROM sfms_setting LIMIT 1 ";
    $result = $connect->query($query, PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $school_name = $row['school_name'];
        $school_address = $row['school_address'];
        $school_email_address = $row['school_email_address'];
        $school_website = $row['school_website'];
        $school_contact_number = $row['school_contact_number'];
        $setting_id = $row['setting_id'];
    }

    include('header.php');
?>
<div class="container-fluid mt-4">
    <h1 class="mt-4">Setting</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Setting</li>
    </ol>

    <div class="row">
        <div class="col-md-6">
            <?php 
                echo $message;
                if($error != '')
                {
                    echo '<div class="alert alert-danger alert-dismissible fade show">'.$error.'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                }
            ?>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-edit"></i> Setting
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="school_name">School Name <span class="text-danger">*</span> </label>
                            <input type="text" name="school_name" id="school_name" class="form-control" value="<?php echo $school_name; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="school_address">Address</label>
                            <input type="text" name="school_address" id="school_address" class="form-control" value="<?php echo $school_address; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="school_contact_number">Contact No</label>
                            <input type="text" name="school_contact_number" id="school_contact_number" class="form-control" value="<?php echo $school_contact_number; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="school_email_address">Email Address </label>
                            <input type="text" name="school_email_address" id="school_email_address" class="form-control"value="<?php echo $school_email_address; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="school_website">Website</label>
                            <input type="text" name="school_website" id="school_website" class="form-control" value="<?php echo $school_website; ?>">
                        </div>
                        <div class="mt-4 mb-0">
                            <input type="hidden" name="setting_id" id="setting_id" value="<?php echo $setting_id; ?>">
                            <input type="submit" name="setting_user" id="setting_user" value="Save" class="btn btn-primary btn-sm">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include('footer.php');
?>