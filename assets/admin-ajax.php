<script language="javascript" type="text/javascript">
    function getXMLHTTP() { //fuction to return the xml http object
        var xmlhttp = false;
        try {
            xmlhttp = new XMLHttpRequest();
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e1) {
                    xmlhttp = false;
                }
            }
        }

        return xmlhttp;
    }

    function check_duplicate_emp_id(val) {
        var base_url = '<?= base_url() ?>';
        var strURL = base_url + "admin/global_controller/check_duplicate_emp_id/" + val;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        var result = req.responseText;
                        if (result) {
                            $("#id_exist_msg").append(result);
                            document.getElementById('sbtn').disabled = true;
                        } else {
                            document.getElementById('sbtn').disabled = false;
                        }

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("POST", strURL, true);
            req.send(null);
        }
    }

    $(document).on("change", function () {
        var change_email_password = $('#change_email_password').val();
        var old_password = $('#old_password').val();
        var change_username = $('#change_username').val();
        var check_username = $('#check_username').val();
        var employment_id = $('#check_employment_id').val();
        var check_email_addrees = $('#check_email_addrees').val();
        var user_id = $('#user_id').val();
        var id, btn, value, url, userid;

        if (change_email_password) {
            id = 'email_password';
            btn = 'new_uses_btn';
            value = change_email_password;
            url = 'check_current_password';
        }
        if (old_password) {
            id = 'old_password_error';
            btn = 'old_password_button';
            value = old_password;
            url = 'check_current_password';
        }
        if (change_username) {
            id = 'username_error';
            btn = 'change_username_btn';
            value = change_username;
            userid = user_id;
            url = 'check_current_password';
        }
        if (check_username) {
            id = 'check_username_error';
            btn = 'new_uses_btn';
            url = 'check_existing_user_name'
            value = check_username;
        }
        if (employment_id) {
            id = 'employment_id_error';
            btn = 'new_uses_btn';
            url = 'check_duplicate_emp_id'
            value = employment_id;
            userid = user_id;
        }
        if (check_email_addrees) {
            id = 'email_addrees_error';
            btn = 'new_uses_btn';
            url = 'check_email_addrees'
            value = check_email_addrees;
            userid = user_id;
        }
        if (userid) {
            user_id = userid;
        } else {
            user_id = "";
        }
        if (url) {
            $.ajax({
                url: base_url + "admin/global_controller/" + url + '/' + user_id,
                type: "POST",
                data: {
                    name: value,
                },
                dataType: 'json',
                success: function (res) {
                    if (res.error) {
                        handle_error("#" + id, res.error);
                        disable_button("#" + btn);
                        return;
                    } else {
                        remove_error("#" + id);
                        disable_remove("#" + btn);
                        return;
                    }
                }
            });
        }
    });


    function check_current_password(val) {
        var base_url = '<?= base_url() ?>';
        var strURL = base_url + "admin/global_controller/check_current_password/" + val;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        var result = req.responseText;
                        if (result) {
                            $("#id_error_msg").css("display", "block");
                            document.getElementById('sbtn').disabled = true;
                        } else {
                            $("#id_error_msg").css("display", "none");
                            document.getElementById('sbtn').disabled = false;
                        }

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("POST", strURL, true);
            req.send(null);
        }

    }




    // Init bootstrap select picker
    function init_selectpicker() {
        $('body').find('select.selectpicker').not('.ajax-search').selectpicker({
            showSubtext: true,
        });
    }

    function capitalise(string) {
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }

    function check_user_name(str) {

        var user_name = $.trim(str);
        var user_id = $.trim($("#user_id").val());
        var base_url = '<?= base_url() ?>';
        var strURL = base_url + "admin/global_controller/check_existing_user_name/" + user_name + "/" + user_id;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        var result = req.responseText;
                        document.getElementById('username_result').innerHTML = result;
                        var msg = result.trim();
                        if (msg) {
                            document.getElementById('sbtn').disabled = true;
                        } else {
                            document.getElementById('sbtn').disabled = false;
                        }

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("POST", strURL, true);
            req.send(null);


        }
    }

 


</script>