<?php
/*
    Template Name: Registration page
    */
get_header();

if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
	$companyName               = $_POST['companyName'];
	$companyEmail              = $_POST['companyEmail'];
	$companyPhoneNumber        = $_POST['companyPhoneNumber'];
	$postalCode                = $_POST['postalCode'] . $_POST['postalCode2'];
	$prefectures               = $_POST['prefectures'];
	$municipality              = $_POST['municipality'];
	$streetAddress             = $_POST['streetAddress'];
	$surname                   = $_POST['surname'];
	$last_name                 = $_POST['last_name'];
	$surname2                  = $_POST['surname2'];
	$name2                     = $_POST['name2'];
	$companyPosition           = $_POST['companyPosition'];
	$representativePhoneNumber = $_POST['representativePhoneNumber'];
	$representativeEmail       = $_POST['representativeEmail'];
	$password                  = $_POST['password'];

	$user_id = username_exists( $representativeEmail );

	if ( ! $user_id && false == email_exists( $representativeEmail ) ) {

		$user_id = wp_create_user( $representativeEmail, $password, $representativeEmail );
		$status  = 1;

		update_user_meta( $user_id, 'billing_company', $companyName );
		update_user_meta( $user_id, 'companyy_email', $companyEmail );
		update_user_meta( $user_id, 'companyy_phone', $companyPhoneNumber );
		update_user_meta( $user_id, 'billing_postcode', $postalCode );
		update_user_meta( $user_id, 'billing_country', 'JP' );
		update_user_meta( $user_id, 'billing_state', $prefectures );
		update_user_meta( $user_id, 'billing_city', $municipality );
		update_user_meta( $user_id, 'billing_address_1', $streetAddress );
		update_user_meta( $user_id, 'billing_first_name', $surname );
		update_user_meta( $user_id, 'first_name', $surname );
		update_user_meta( $user_id, 'billing_last_name', $last_name );
		update_user_meta( $user_id, 'last_name', $last_name );
		update_user_meta( $user_id, 'surname_pronounce', $surname2 );
		update_user_meta( $user_id, 'name_pronounce', $name2 );
		update_user_meta( $user_id, 'company_position', $companyPosition );
		update_user_meta( $user_id, 'billing_phone', $representativePhoneNumber );
		update_user_meta( $user_id, 'billing_email', $representativeEmail );
	} else {
		$random_password = __( 'User already exists.  Password inherited.', 'textdomain' );
		$status          = 0;
	}

}


?>


    <section class="my-4 container-xl px-4 px-lg-3 px-xxl-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="text-dark" href="#">
                    <?php if(get_locale() == 'ja') { 
                    echo "家";
                  }
                    else{
                      echo "Home";
                      }
                ?>
                </a>
                </li>
                <li class="breadcrumb-item active">
                    <a class="text-dark" href="#">
                    <?php if(get_locale() == 'ja') { 
                    echo "登録";
                  }
                    else{
                      echo "Register";
                      }
                ?>    
                    </a>
                </li>
            </ol>
        </nav>
    </section>

    <section class="my-4 container-xl px-4 px-lg-3 px-xxl-5 pb-5">
        <h4 class="text-center">
        <?php if(get_locale() == 'ja') { 
                    echo "登録";
                  }
                    else{
                      echo "Registration";
                      }
                ?>    
        </h4>
		<?php if ( $_SERVER["REQUEST_METHOD"] == "POST" ) { ?>
			<?php if ( $status ) { ?>
                <div class="woocommerce-notices-wrapper">
                    <div class="woocommerce-message" role="alert">
                    <?php if(get_locale() == 'ja') { 
                    echo "登録完了。今すぐログインできます";
                  }
                    else{
                      echo "Registration Success. You can login now";
                      }
                ?>    
                    
                    </div>
                </div>
			<?php } else { ?>
                <div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout">
                    <ul class="woocommerce-error" role="alert">
                        <li data-id="billing_postcode">
                            <strong>
                            <?php if(get_locale() == 'ja') { 
                                echo "ユーザーの電子メールはすでに存在します。";
                            }
                                else{
                                echo "User Email already Exist.";
                                }
                            ?>    
                            
                    <a href="<?php echo get_site_url(); ?>/registration/">
                    <?php if(get_locale() == 'ja') { 
                                echo "再試行";
                            }
                                else{
                                echo "Try again";
                                }
                            ?> 
                    </a></li>
                    </ul>
                </div>
			<?php }
		} else { ?>
            <div class="col-lg-7 mx-auto my-5">
                <form class="needs-validation" novalidate method="post"
                      action="">
                    <div class="row g-3">
                        <h6 class="mt-3 text-center fw-bold">
                        <?php if(get_locale() == 'ja') { 
                            echo "会社の詳細";
                        }
                            else{
                            echo "Company Details";
                            }
                        ?>    
                        </h6>

                        <div class="col-md-6 mb-2">
                            <label for="companyName" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "会社名";
                            }
                                else{
                                echo "Company Name";
                                }
                            ?>    
                            </label>
                            <input
                                    type="text"
                                    class="form-control rounded-0"
                                    id="companyName"
                                    name="companyName"
                                    placeholder="Eg. Fuji Corporation Ltd"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>    
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="companyEmail" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "会社の電子メール";
                            }
                                else{
                                echo "Company Email";
                                }
                            ?>    
                            </label>
                            <input
                                    type="email"
                                    class="form-control rounded-0"
                                    id="companyEmail"
                                    name="companyEmail"
                                    placeholder="Eg. info@jpal.co.jp"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>    
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="phoneNumber" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                    echo "会社の電話番号";
                                    }
                                    else{
                                    echo "Company Phone number";
                                    }
                                ?>    
                            </label>
                            <input
                                    type="text"
                                    class="form-control rounded-0"
                                    id="companyPhoneNumber"
                                    name="companyPhoneNumber"
                                    placeholder="Eg. 0263-98-3280"
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>    
                            </div>
                        </div>

                        <h6 class="mt-5 text-center fw-bold">
                        <?php if(get_locale() == 'ja') { 
                                echo "住所";
                            }
                                else{
                                echo "Address";
                                }
                            ?>
                        </h6>
                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="postalCode" class="form-label">
                                <?php if(get_locale() == 'ja') { 
                                    echo "郵便番号";
                                }
                                    else{
                                    echo "Postal code ";
                                    }
                                ?>    
                                </label>
                                <div class="col-6">
                                    <input
                                            type="number"
                                            class="form-control rounded-0"
                                            id="postalCode"
                                            name="postalCode"
                                            max="999"
                                            min="0"
                                            placeholder="Eg. 000"
                                            required
                                    />
                                    <div class="invalid-feedback">
                                    <?php if(get_locale() == 'ja') { 
                                        echo "このフィールドに入力してください。";
                                    }
                                        else{
                                        echo "Please fill this field.";
                                        }
                                    ?>    
                                    </div>
                                </div>
                                <div class="col-6">
                                    <input
                                            type="number"
                                            class="form-control rounded-0"
                                            id="postalCode2"
                                            name="postalCode2"
                                            max="9999"
                                            min="0"
                                            placeholder="Eg. 2123"
                                            required
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="prefectures" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "都道府県";
                            }
                                else{
                                echo "Prefectures ";
                                }
                            ?>    
                            </label>
                            <input
                                    type="text"
                                    class="form-control rounded-0"
                                    id="prefectures"
                                    name="prefectures"
                                    placeholder=""
                                    disabled
                            />
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="municipality" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "自治体";
                            }
                                else{
                                echo "Municipality ";
                                }
                            ?>    
                            </label>
                            <input
                                    type="text"
                                    class="form-control rounded-0"
                                    id="municipality"
                                    name="municipality"
                                    disabled
                                    required
                            />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="address" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                    echo "住所";
                                }
                                    else{
                                    echo "Address ";
                                    }
                                ?>    
                            </label>
                            <input
                                    type="text"
                                    class="form-control rounded-0"
                                    id="address"
                                    name="streetAddress"
                                    placeholder="Please Enter Company Address"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>    
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <h6 class="mt-5 text-center fw-bold">
                        <?php if(get_locale() == 'ja') { 
                                echo "アカウント担当者の場合";
                            }
                                else{
                                echo "For Account Representative";
                                }
                            ?>    
                        </h6>
                        <div class="col-md-6 mb-2">
                            <label for="surname" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "姓";
                            }
                                else{
                                echo "Surname";
                                }
                            ?>    
                            </label>
                            <input
                                    type="text"
                                    class="form-control rounded-0"
                                    id="surname"
                                    name="surname"
                                    placeholder="Eg. Yamada"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>    
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="name" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "名前";
                            }
                                else{
                                echo "Name";
                                }
                            ?>    
                            </label>
                            <input
                                    type="text"
                                    class="form-control rounded-0"
                                    id="name"
                                    name="last_name"
                                    placeholder="Eg. Taro"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="surname2" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "姓";
                            }
                                else{
                                echo "Surname";
                                }
                            ?>    
                            </label>
                            <input
                                    type="text"
                                    class="form-control rounded-0"
                                    id="surname2"
                                    name="surname2"
                                    placeholder="Eg. Yamada"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>    
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="name2" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "名前";
                            }
                                else{
                                echo "Name";
                                }
                            ?>    
                            </label>
                            <input
                                    type="text"
                                    class="form-control rounded-0"
                                    id="name2"
                                    name="name2"
                                    placeholder="Eg. Taro"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>    
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="companyPosition" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "会社の位置";
                            }
                                else{
                                echo "Company Position";
                                }
                            ?>    
                            </label>
                            <input
                                    type="text"
                                    class="form-control rounded-0"
                                    id="companyPosition"
                                    name="companyPosition"
                                    placeholder="Eg. Manager"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>    
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="representativePhoneNumber" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "電話番号";
                            }
                                else{
                                echo "Phone Number";
                                }
                            ?>    
                            </label>
                            <input
                                    type="tel"
                                    class="form-control rounded-0"
                                    id="representativePhoneNumber"
                                    name="representativePhoneNumber"
                                    placeholder="Eg. 0263-98-3280"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>    
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="representativeEmail" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "電子メールアドレス";
                            }
                                else{
                                echo "Email address";
                                }
                            ?>
                </label>
                            <input
                                    type="email"
                                    class="form-control rounded-0"
                                    id="representativeEmail"
                                    name="representativeEmail"
                                    placeholder="Eg. "
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                    echo "このフィールドに入力してください。";
                                }
                                    else{
                                    echo "Please fill this field.";
                                    }
                                ?>    
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <h6 class="mt-5 text-center fw-bold">
                        <?php if(get_locale() == 'ja') { 
                            echo "パスワード";
                        }
                            else{
                            echo "Password";
                            }
                        ?>    
                        </h6>
                        <div class="col-md-6 mb-2">
                            <label for="password" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                echo "パスワードを作成";
                            }
                                else{
                                echo "Create a password";
                                }
                            ?>    
                            </label>
                            <input
                                    type="password"
                                    class="form-control rounded-0"
                                    id="password"
                                    name="password"
                                    placeholder="Please Enter Password"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                echo "このフィールドに入力してください。";
                            }
                                else{
                                echo "Please fill this field.";
                                }
                            ?>    
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="rePassword" class="form-label">
                            <?php if(get_locale() == 'ja') { 
                                    echo "パスワードを再入力してください";
                                }
                                    else{
                                    echo "Re enter the password";
                                    }
                                ?>    
                            </label>
                            <input
                                    type="password"
                                    class="form-control rounded-0"
                                    id="rePassword"
                                    name="rePassword"
                                    placeholder="Please Re-Enter Password"
                                    required
                            />
                            <div class="invalid-feedback">
                            <?php if(get_locale() == 'ja') { 
                                    echo "このフィールドに入力してください。";
                                }
                                    else{
                                    echo "Please fill this field.";
                                    }
                                ?>    
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-success rounded-0 px-3">
                        <?php if(get_locale() == 'ja') { 
                            echo "送信";
                        }
                            else{
                            echo "Submit";
                            }
                        ?>    
                        </button>
                    </div>
                </form>
            </div>
		<?php } ?>
    </section>

<?php get_footer(); ?>