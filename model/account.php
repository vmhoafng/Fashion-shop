<?php

function check_user($user_email, $user_password)
{
    $sql = "SELECT ur.role_id, u.* 
            FROM user u INNER JOIN userrole ur ON u.user_id = ur.user_id 
            WHERE u.user_email = '%s' AND u.user_password ='%s' AND u.user_account_status = 1";

    $sql = sprintf($sql, $user_email, $user_password);
    $rs = pdo_query_one($sql);

    return $rs;
}

function check_email($user_email)
{
    $sql = "SELECT COUNT(*) AS email_count, user_email
            FROM user 
            WHERE user_email = '$user_email';";
    $rs = pdo_query_one($sql);

    return $rs;
}

function select_all_user()
{
    $sql = "SELECT ur.role_id, u.* 
            FROM user u INNER JOIN userrole ur ON u.user_id = ur.user_id";
    $rs = pdo_query($sql);

    return $rs;
}

function select_all_user_paganation($start_from, $records_per_page)
{
    $sql = "SELECT ur.role_id, u.* 
            FROM user u 
            INNER JOIN userrole ur ON u.user_id = ur.user_id
            LIMIT $start_from, $records_per_page";
    $rs = pdo_query($sql);

    return $rs;
}

function select_all_user_search($search)
{
    $sql = "SELECT ur.role_id, u.* 
            FROM user u 
            INNER JOIN userrole ur ON u.user_id = ur.user_id
            WHERE u.user_name LIKE '%$search%'
            OR u.user_email LIKE '%$search%'
            OR u.user_phoneNumber LIKE '%$search%'";
    $rs = pdo_query($sql);

    return $rs;
}

function select_all_user_search_paganation($start_from, $records_per_page, $search)
{
    $sql = "SELECT ur.role_id, u.* 
            FROM user u 
            INNER JOIN userrole ur ON u.user_id = ur.user_id
            WHERE u.user_name LIKE '%$search%'
            OR u.user_email LIKE '%$search%'
            OR u.user_phoneNumber LIKE '%$search%'
            LIMIT $start_from, $records_per_page";
    $rs = pdo_query($sql);

    return $rs;
}

function select_one_user($user_id)
{
    $sql = "SELECT ur.role_id, u.* 
            FROM user u INNER JOIN userrole ur ON u.user_id = ur.user_id
            WHERE u.user_id = '$user_id'";
    $rs = pdo_query_one($sql);

    return $rs;
}

function insert_user($user_email, $user_password, $user_name, $user_phoneNumber, $role, $user_address)
{
    $sql = "INSERT INTO user (user_name, user_email, user_password, user_account_status, user_phoneNumber, user_address) 
            SELECT '$user_name', '$user_email', '$user_password', 1, '$user_phoneNumber', '$user_address'
            WHERE NOT EXISTS (
                SELECT 1 FROM user WHERE user_email = '$user_email'
            );
            
            INSERT INTO userrole (user_id, role_id)
            VALUES (LAST_INSERT_ID(), '$role');";

    pdo_execute($sql);
}

function update_user($user_email, $user_password, $user_name, $user_phoneNumber, $user_id, $role_id, $user_address)
{
    $sql = "UPDATE user 
            SET user_name = '$user_name', 
                user_email = '$user_email', 
                user_password = '$user_password', 
                user_phoneNumber = '$user_phoneNumber',
                user_address = '$user_address'
            WHERE user_id = '$user_id';
            
            UPDATE userrole
            SET role_id = '$role_id'
            WHERE user_id = '$user_id';";

    pdo_execute($sql);
}

function lock_user($user_id)
{
    $sql = "UPDATE user 
            SET user_account_status = 0
            WHERE user_id = '$user_id';";

    pdo_execute($sql);
}

function unlock_user($user_id)
{
    $sql = "UPDATE user 
            SET user_account_status = 1
            WHERE user_id = '$user_id';";

    pdo_execute($sql);
}

function get_account($user_id) {
    $sql = "SELECT * FROM user WHERE user_id = $user_id";
    return pdo_query_one($sql);
}