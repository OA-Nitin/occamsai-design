<?php
$title = "Occams Ai";
include('header.php');
?>

<?php

require 'includes/vendor/autoload.php';
// If the .env file was not configured properly, display a helpful message.
if (!file_exists(filename: 'includes/.env')) {
    
    echo'<h1>Missing <code>.env</code></h1>';
    die;
}

// get the current url 

// function simple_encrypt($plaintext) {
//     $method = 'AES-256-CBC';
//     $key = substr(hash('sha256', 'X8d#71a@Ks9!mZqT&2LpE7VxB1CnRu0Y'), 0, 32);
//     $iv  = substr(hash('sha256', 'Nv5$eRq3B8y@L1p!'), 0, 16);

//     return base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv));
// }

function simple_decrypt($ciphertext) {
    $method = 'AES-256-CBC';
    $key = substr(hash('sha256', 'X8d#71a@Ks9!mZqT&2LpE7VxB1CnRu0Y'), 0, 32);
    $iv  = substr(hash('sha256', 'Nv5$eRq3B8y@L1p!'), 0, 16);

    return openssl_decrypt(base64_decode($ciphertext), $method, $key, OPENSSL_RAW_DATA, $iv);
}

// https://occams.ai/staging.occams.ai/registration-form.php/H7jTo5JjwihsU92CyYiaNQ== 
// $data = 1;
// $encrypted = simple_encrypt($data);
// get last part of the url
$lastPart = basename($_SERVER['REQUEST_URI']);
$user_id = simple_decrypt($lastPart);
if (is_numeric($user_id)) {
    $user_id = $user_id;
} else {
    $user_id = 0;
}


// Load `.env` file from the server directory so that
// environment variables are available in $_ENV or via
// getenv().
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$stripe_publish_key = $_ENV["STRIPE_PUBLISHABLE_KEY"];
$stripe_publish_key = 'pk_live_51Q5B28GjjnYtfLHfR9FGv0LwMyveK2CtDl34gEVJQ9Sqb7eX5Ae7BwDFlXorDLFMrLXC3ZOLbxnyS1rIbA7HWAdw00RSq6aulH';


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://occams.ai/app/public/api/all-states',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
curl_close($curl);
$states = json_decode($response);
$state_data = array();
if($states->data){
    $state_data = $states->data;
}

// call service-package-show api
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://occams.ai/app/public/api/service-package-show',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));
    
$response = curl_exec($curl);
curl_close($curl);
$package_data = json_decode($response);
$package_data = $package_data->packages;

?>

<style>
.error-message {
    display: block;
    color: red;
    padding-top: 5px;
}
</style>

<section class="bg-[#F5F5F5] mt-[92px] dark:bg-slate-800 dark:text-black">
    <div class="container px-10 mt-10 mx-auto rounded-2xl w-full max-w-7xl pt-[30px]">
        <div class="grid grid-cols-1 ">
            <div class="progress-bar text-center">
                <div class="progressbar-1">
                    <div class="line145_one">
                    </div>
                    <h1 class="entitysetup0com ui heading size-headinglg">
                        <span id="step-title" class="entitysetup0com-span heading-3 heading-color">
                            Entity Setup
                        </span>
                        <span class="entitysetup0com-span-1"><br></span>
                        <span id="progress-text" class="entitysetup0com-span-2 dark:text-white">
                            0% completed
                        </span>
                    </h1>

                    <div class="line145_one">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 px-4 mx-auto w-full max-w-7xl lg:pb-20">
        <div class="grid grid-cols-1 mt-10 bg-white rounded-3xl p-10 dark:bg-slate-500">


            <form id="stepForm" class="multi-step-form">


                <fieldset class="step" data-step="1">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-6">
                        <div>
                            <label class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    <small class="text-red-500">*</small> State
                                </span>
                                <span class="text-gray-400 cursor-pointer" title="Select your state">
                                    <i class="fa-solid fa-circle-info"></i>
                                </span>
                            </label>

                            <select id="state" name="state" class="w-full border rounded-md" required onchange="getStateFee()">
                                <option value="">Select State</option>
                                <?php foreach ($state_data as $skey => $svalue) { ?>
                                        <option value="<?php echo $svalue->iso_code; ?>"><?php echo $svalue->state_name; ?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                            <!-- <span class=" state-error hidden">Please select State</span> -->
                            <span class="error-message state-error"></span>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    <small class="text-red-500">*</small> Company Type
                                </span>
                                <span class="text-gray-400 cursor-pointer" title="Select your state">
                                    <i class="fa-solid fa-circle-info"></i>
                                </span>
                            </label>
                            <select name="companyType" id="company-type" class="w-full border rounded-md pr-10" required>
                                <option value="">Select Company Type</option>
                                <option value="llc">LLC</option>
                                <option value="s-corp">S Corporation</option>
                                <option value="c-corp">C Corporation</option>
                            </select>
                            <span class="error-message "></span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 pt-6 mt-10 pb-10">
                        <div class="flex justify-between items-center border-t border-b border-[#E5E5E5] py-8">
                            <h1 class="subheadline_medium subheadline_medium_fee">State filing fee : <span
                                    class="heading-color"><b>$0.00</b></span></h1>
                                    <input type="hidden" id="state-fee-id" value="0">
                                    <input type="hidden" id="company_formation_id" value="">
                                    <input type="hidden" id="deleted_director_id" value="">
                                    <input type="hidden" id="deleted_shareholder_id" value="">
                                    <input type="hidden" id="current_user_id" value="<?php echo $user_id; ?>">

                            <button type="button" class="btn-next">Next <i class="fa fa-chevron-right"></i></button>

                        </div>
                    </div>

                    <div class=" mt-10 rounded-xl py-10 banner-cta-box-2">
                        <div
                            class="flex flex-col lg:flex-row items-center md:justify-evenly gap-6 text-center md:text-left">

                            <div class="cols flex-1">
                                <h1 class="text-[#004893] text-3xl font-bold lg:pl-[100px] ">Schedule A Free
                                    Consultation</h1>
                            </div>

                            <div class="cols flex-1">
                                <p class="text-[#004893] text-xl font-normal max-w-md lg:pr-[70px]">
                                    If you are unsure about the structure or state, schedule a free 15-minute
                                    consultation.
                                </p>

                            </div>
                            <div class="cols flex-1">
                                <a href="https://calendly.com/d/crw3-69s-wgk/start-smart-free-incorporation-consultation?month=2025-04" target="_blank" style="width:80%"
                                    class="bg-[#F36B21] text-white px-[75px] py-[10px] flex items-center gap-2 rounded-md">
                                    <img src="https://occams.ai/assets/images/images/cta-logo.svg" alt="cta-logo"> Book
                                    a
                                    meeting
                                </a>
                            </div>
                        </div>
                    </div>


                </fieldset>

                <fieldset class="step hidden" data-step="2">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-6">
                        <div>

                            <label class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    <small class="text-red-500">*</small>Business name
                                </span>
                                <span class="text-gray-400 cursor-pointer" title="Select your state">
                                    <i class="fa-solid fa-circle-info"></i>
                                </span>
                            </label>
                            <input type="text" placeholder="Minecodes Technology" id="business_name"
                                name="business_name" class="w-full p-2 border rounded-md">
                                <span class="error-message "></span>
                        </div>
                        <div>

                            <label class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    <small class="text-red-500">*</small>Designator
                                </span>
                            </label>
                            <select name="companyType" id="designator-select" class="w-full p-2 border rounded-md designator-select" required>
                                <option value="llc">LLC</option>
                                <option value="s-corp">S Corporation</option>
                            </select>
                            <span class="error-message "></span>
                            <span class="hidden">Please select company type</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 mt-6 lg:mt-10">
                        <div>

                            <label class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    <small class="text-red-500">*</small>Your official company name will
                                    display as
                                </span>

                            </label>

                            <input type="text" placeholder="Minecodes Technology LLC" id="company-name-id"
                                name="official_business_name" class="w-full p-2 border rounded-md" disabled>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 mt-6 lg:mt-10">
                        <label class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                            <span>
                                Purpose of the Company (You have 100 characters
                                left)
                            </span>

                        </label>
                        <textarea id="purpose" name="company_purpose" class="w-full p-2 border rounded-md"
                            rows="4"></textarea>
                        <span class="error-message "></span>
                    </div>


                    <div class="back-next-footer d-flex justify-content-end align-items-center">
                        <button type="button" class="back-button"><i class="fa fa-chevron-left"></i> Back</button>
                        <button type="button" class="btn-next">Next <i class="fa fa-chevron-right"></i></button>
                    </div>
                </fieldset>


                <fieldset class="step hidden" data-step="3">

                    <div class="llc_fields_container">

                        <div class="grid grid-cols-1  gap-8 pt-6">

                            <div id="llc-shares-structure" class="form__fields-column">

                                <div class="form__field">
                                    <p><small class="text-red-500">*</small> How will this LLC be managed?</p>
                                    <div class="llc-managed-radio flex ">
                                        <div><label class="howwillthis">
                                                <input type="radio" data-tab="member" class="member-type radio"
                                                    value="member_managed" id="member-id" name="member_type" checked
                                                    autocomplete="off">
                                                <span>Member managed</span>
                                            </label></div>
                                        <div>
                                            <label class="howwillthis">
                                                <input data-tab="manager" type="radio" class="member-type radio"
                                                    value="manager_managed" id="manager-id" name="member_type"
                                                    autocomplete="off">
                                                <span>Manager managed</span>
                                            </label>
                                        </div>
                                    </div>
                                    <span class="error-message"></span>
                                </div>

                            </div>
                            </div>

                            <!-- <div class="manager-section mt-6"> -->
                            <div class="mt-6">

                            <div class=" grid grid-cols-1 pt-6  border border-[#99A0A6] lg:pt-[10px] lg:pr-[20px] lg:pb-[0px] lg:pl-[20px]">
                                <div>
                                    <div class="tab-wrapper relative">
                                        <div class="tabs ">
                                            <div class="tab manager-section" data-tab="manager">Manager details <span
                                                    class="count" id="manager-count">(1)</span></div>
                                            <div class="tab member-section active" data-tab="member">Member details <span class="count" id="member-count">(1)</span>
                                            </div>
                                        </div>
                                        <button class="bg-[#E9F5F3]  border ml-3 border-[#E9F5F3] p-4 rounded" type="button"
                                            id="manager-button" onclick="addFieldsRow('manager','manager','manager-details__fields')">+ Add
                                            managers</button>
                                        <button class="bg-[#FFE7DA] ml-3 border border-[#FFE7DA] p-4 rounded" type="button"
                                            id="member-button" onclick="addFieldsRow('member-container','member','member-profile-form')">+ Add
                                            members</button>
                                    </div>
                                </div>


                                <div class="tab-content" id="manager">
                                    <div class="flex flex-wrap justify-between gap-4 items-center mt-4 manager-details__fields">
                                        <div class="w-[15%]">
                                            <div class="form__member-row">
                                                <div class="form__member-counter-container">
                                                    <p class="header__profile-name">Manager 1</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-[20%]">
                                            <div class="form__field-2">
                                                <label class="form__label">Manager name</label>
                                                <input type="hidden" name="managers_id_1" id="managers_id_1" value="">
                                                <div class="form__input"><input name="manager_name_1" type="text" autocomplete="off"></div>
                                                <span class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="w-[20%]">
                                            <div class="form__field-2">
                                                <label class="form__label">Manager address</label>
                                                <div class="form__input"><input name="manager_address_1" class="rv-address" type="text" autocomplete="off"></div>
                                                <span class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="w-[30%] manager-member__form-section">
                                            <div class="flex flex-col">
                                                <label class="mb-1">Is this manager also a member (Owner)?</label>
                                                <div class="flex space-x-4">
                                                    <label class="flex items-center space-x-1">
                                                        <input type="radio" name="manager_owner_1" no_id="1" value="yes" class="form-radio text-orange-500 member_manager" >
                                                        <span>Yes</span>
                                                    </label>
                                                    <label class="flex items-center space-x-1">
                                                        <input type="radio" name="manager_owner_1" no_id="1" value="no" class="form-radio text-gray-500 member_manager" checked>
                                                        <span>No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-[5%] flex justify-center items-center">
                                            <img src="https://occams.ai/assets/images/images/delete-gray.svg" alt="delete"  title="Remove" class="cursor-pointer">

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content active" id="member">
                                    <div class="grid grid-cols-1 pt-6 border border-[#99A0A6] lg:pt-[10px] lg:pr-[20px] lg:pb-[0px] lg:pl-[20px]">
                                        <div class="mt-10 mb-8" id="member-container">
                                            <div class="flex flex-wrap justify-between gap-4 items-center mt-4 member-profile-form">
                                                <div class="w-[15%]">
                                                    <div class="form__member-row bg-[#FFE7DA73]">
                                                        <div class="form__member-counter-container">
                                                            <p class="header__profile-name">Member 1</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-[25%]">
                                                    <div class="form__field-2">
                                                        <label class="form__label">Member name</label>
                                                        <input type="hidden" name="owner_id_1" id="owner_id_1" value="">
                                                        <div class="form__input"><input name="member_name_1" type="text" autocomplete="off"></div>
                                                        <span class="error-message"></span>
                                                    </div>
                                                </div>
                                                <div class="w-[35%]">
                                                    <div class="form__field-2">
                                                        <label class="form__label">Member address</label>
                                                        <div class="form__input"><input name="member_address_1" class="rv-address" type="text" autocomplete="off"></div>
                                                        <span class="error-message"></span>
                                                    </div>
                                                </div>
                                                <div class="w-[12%]">
                                                    <div class="form__field-2">
                                                        <label class="form__label">Ownership %</label>
                                                        <div class="form__input"><input class="ownership_percentage_value" name="shareholder_shares_1" type="number" placeholder="%" min="0" autocomplete="off"></div>
                                                        <span class="error-message"></span>
                                                    </div>
                                                </div>
                                                <div class="w-[5%] flex justify-center items-center">
                                                    <img src="https://occams.ai/assets/images/images/delete-gray.svg" alt="delete"  title="Remove" class="cursor-pointer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                    <div class="corporation_fields_container" style="display:none">

                        
                        <p><span class="text-red-500">*</span>Shareholder (owner) information</p>
                        <h6 class="subheadline_medium">Who owns shares in the corporation?</h6>


                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label for="number-of-shares"
                                    class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                    <span>
                                        <small class="text-red-500">*</small>Number of shares authorized
                                    </span>

                                </label>
                                <input type="text" placeholder="Enter number of shares" id="shares-authorized"
                                    name="number-of-shares" class="w-full p-2 border rounded-md">
                                    <span class="error-message"></span>
                            </div>

                            <div>
                                <label for="share-value"
                                    class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                    <span>
                                        <small class="text-red-500">*</small>Par value of shares ($)
                                    </span>

                                </label>
                                <input type="text" placeholder="Enter par value of shares" id="par-value"
                                    name="share-value" class="w-full p-2 border rounded-md">
                                    <span class="error-message"></span>
                            </div>
                        </div>


                        <div class="grid grid-cols-1  gap-8 pt-10">


                            <div class="grid grid-cols-1 pt-6  border border-[#99A0A6] lg:pt-[10px] lg:pr-[20px] lg:pb-[0px] lg:pl-[20px]">

                                <div class="flex justify-between relative">
                                    <button class=" border border-[#99A0A6] p-4">Shareholder <span
                                            class="text-[var(--primary)]" id="shareholder-count"> (1)</span></button>
                                    <div class="vertical-line"></div>
                                    <button class="bg-[#f4f4f4]  border border-[#99A0A6] p-4 rounded ml-3" type="button" onclick="addFieldsRow('shareholder-container','shareholder','shareholder-profile-form')">+ Add
                                        Shareholder</button>
                                </div>

                                <div class="mt-10 mb-8" id="shareholder-container">
                                    <div class="flex flex-wrap justify-between  items-center mt-4 shareholder-profile-form">
                                        <div class="w-[15%]">
                                            <div class="form__member-row bg-[#F4F4F4]">
                                                <div class="form__member-counter-container">
                                                    <p class="header__profile-name">Shareholder 1</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-[18%]">
                                            <div class="form__field-2">
                                                <label for="share-holder-name" class="form__label"><small
                                                        class="text-red-500">*</small>Shareholder name</label>
                                                <input type="hidden" name="share-holder-name" id="share-holder-name"
                                                    value="" autocomplete="off">
                                                <div class="form__input"><input name="shareholder_name_1" type="text"
                                                        autocomplete="off"></div>
                                                <span class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="w-[18%]">
                                            <div class="form__field-2">
                                                <label for="shareholder_address" class="form__label"><small
                                                        class="text-red-500">*</small>Shareholder address</label>
                                                <div class="form__input"><input class="rv-address" name="shareholder_address_1" type="text"
                                                        autocomplete="off"></div>
                                                <span class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="w-[20%]">
                                            <div class="form__field-2">
                                                <label for="number-of-share-owned" class="form__label"><small
                                                        class="text-red-500">*</small>Number of shares owned</label>
                                                <div class="form__input"><input name="shareholder_shares_1" type="number" class="shares_num"
                                                        min="0" autocomplete="off"></div>
                                                <span class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="w-[16%]">
                                            <div class="form__field-2">
                                                <label for="is-director-or-officer" class="form__label"><small
                                                        class="text-red-500">*</small>Is Director/Officer?</label>
                                                <div class="form__input">
                                                    <select class="w-full border border-black rounded"
                                                        name="shareholder_director_1" id="shareholder_director_1">
                                                        <option value="NA">NA</option>
                                                        <option value="Director">Director</option>
                                                        <option value="President/CEO">President/CEO</option>
                                                        <option value="Secretary">Secretary</option>
                                                        <option value="TReasurer/CFO">TReasurer/CFO</option>
                                                    </select>
                                                </div>
                                                <span class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="w-[2%] flex justify-center items-center">
                                            <img src="https://occams.ai/assets/images/images/delete-gray.svg" alt="delete"
                                                title="Remove" class="cursor-pointer">
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
             
                    <div class="back-next-footer d-flex justify-content-end align-items-center">
                        <button type="button" class="back-button"><i class="fa fa-chevron-left"></i> Back</button>
                        <button type="button" class="btn-next">Next <i class="fa fa-chevron-right"></i></button>
                    </div>
                </fieldset>

                <fieldset class="step hidden" data-step="4">

                    <p><span class="text-red-500">*</span>Directors (Who Oversees the Corporation?)</p>
                    <h6 class="subheadline_medium">Directors govern the company but do not handle daily operations</h6>

                    <div class="grid grid-cols-1  gap-8 pt-10">
                        <div
                            class=" grid grid-cols-1 pt-6  border border-[#99A0A6] lg:pt-[10px] lg:pr-[20px] lg:pb-[0px] lg:pl-[20px]">
                            <div>
                                <div class="tab-wrapper relative">
                                    <div class="tabs">
                                        <div class="tab active" data-tab="director-container">Director <span
                                                class="count" id="director-count">(2)</span></div>
                                        <div class="tab" data-tab="officer-information">Officer Information <span
                                                class="count" >(3)</span>
                                        </div>
                                    </div>
                                    <button class="bg-[#E9F5F3]  border border-[#E9F5F3] p-4 rounded"
                                        id="director-button" onclick="addFieldsRow('director-container','director','member-profile-form')">+ Add Director</button>

                                </div>
                            </div>

                            <div class="tab-content active" id="director-container">
                                <div class="flex flex-wrap justify-between gap-4 items-center mt-4 member-profile-form">
                                    <div class="w-[15%]">
                                        <div class="form__member-row">
                                            <div class="form__member-counter-container">
                                                <p class="header__profile-name">Director 1</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-[30%]">
                                        <div class="form__field-2">
                                            <label class="director-name"><small class="text-red-500">*</small>Director
                                                name</label>
                                            <input type="hidden" name="director_id_1" id="director_id_1" value=""
                                                autocomplete="off">
                                            <div class="form__input"><input name="director_name_1" id="director_name_1" type="text"
                                                    autocomplete="off"></div>
                                            <span class="error-message"></span>
                                        </div>
                                    </div>
                                    <div class="w-[45%]">
                                        <div class="form__field-2">
                                            <label for="director-address" class="form__label"><small
                                                    class="text-red-500">*</small>Director address</label>
                                            <div class="form__input">
                                                <input name="director_address_1" type="text" autocomplete="off"
                                                    id="director_address_1">
                                            </div>
                                            <span class="error-message"></span>
                                        </div>
                                    </div>

                                    <div class="w-[5%] flex justify-center items-center">
 
                                            <img src="https://occams.ai/assets/images/images/delete-gray.svg" alt="delete"
                                                title="Remove" class="cursor-pointer">
                                    </div>
                                </div>

                            </div>

                            <div class="tab-content" id="officer-information">
                                <div
                                    class="grid grid-cols-1 pt-6  border border-[#99A0A6] lg:pt-[10px] lg:pr-[20px] lg:pb-[0px] lg:pl-[20px]">

                                    <div class="mt-10 mb-8">
                                        <div class="flex flex-wrap justify-between gap-4 items-center mt-4">
                                            <div class="w-[15%]">
                                                <div class="form__member-row bg-[#F4F4F4]">
                                                    <div class="form__member-counter-container">
                                                        <p class="header__profile-name">President <br> /CEO</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-[30%]">
                                                <div class="form__field-2">
                                                    <label for="president-ceo-name" class="director-name"><small
                                                            class="text-red-500">*</small>President/CEO name</label>
                                                    <input type="hidden" name="president_ceo_id"
                                                        id="president_ceo_id" value="" autocomplete="off">
                                                    <div class="form__input"><input name="president_ceo_name"
                                                            type="text" autocomplete="off" id="president_ceo_name"></div>
                                                    <span class="error-message"></span>
                                                </div>
                                            </div>
                                            <div class="w-[45%]">
                                                <div class="form__field-2">
                                                    <label for="president_ceo_address" class="form__label"><small
                                                            class="text-red-500">*</small>President/CEO address</label>
                                                    <div class="form__input">
                                                        <input name="president_ceo_address" type="text" class="rv-address"
                                                            autocomplete="off" id="president_ceo_address">
                                                    </div>
                                                    <span class="error-message"></span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="flex flex-wrap justify-between gap-4 items-center mt-4">
                                            <div class="w-[15%]">
                                                <div class="form__member-row bg-[#F4F4F4]">
                                                    <div class="form__member-counter-container">
                                                        <p class="header__profile-name">TReasuren <br> /CFO</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-[30%]">
                                                <div class="form__field-2">
                                                    <label for="treasuren-cfo-name" class="director-name"><small
                                                            class="text-red-500">*</small>TReasuren/CFO name</label>
                                                    <input type="hidden" name="treasurer_cfo_id"
                                                        id="treasurer_cfo_id" value="" autocomplete="off">
                                                    <div class="form__input"><input name="treasurer_cfo_name"
                                                            type="text" autocomplete="off" id="treasurer_cfo_name"></div>
                                                    <span class="error-message"></span>
                                                </div>
                                            </div>
                                            <div class="w-[45%]">
                                                <div class="form__field-2">
                                                    <label for="treasurer_cfo_address" class="form__label"><small
                                                            class="text-red-500">*</small>TReasuren/CFO address</label>
                                                    <div class="form__input">
                                                        <input name="treasurer_cfo_address" type="text" class="rv-address"
                                                            autocomplete="off" id="treasurer_cfo_address">
                                                    </div>
                                                    <span class="error-message"></span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="flex flex-wrap justify-between gap-4 items-center mt-4">
                                            <div class="w-[15%]">
                                                <div class="form__member-row bg-[#F4F4F4]">
                                                    <div class="form__member-counter-container">
                                                        <p class="header__profile-name">Secretory</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-[30%]">
                                                <div class="form__field-2">
                                                    <label for="secretory-name" class="director-name"><small
                                                            class="text-red-500">*</small>Secretory name</label>
                                                    <input type="hidden" name="secretary_id" id="secretary_id"
                                                        value="" autocomplete="off">
                                                    <div class="form__input"><input name="secretary_name" type="text"
                                                            autocomplete="off" id="secretary_name"></div>
                                                    <span class="error-message"></span>
                                                </div>
                                            </div>
                                            <div class="w-[45%]">
                                                <div class="form__field-2">
                                                    <label for="secretory-address" class="form__label"><small
                                                            class="text-red-500">*</small>Secretory address</label>
                                                    <div class="form__input">
                                                        <input name="secretary_address" type="text" autocomplete="off" class="rv-address"
                                                            id="secretary_address">
                                                    </div>
                                                    <span class="error-message"></span>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="back-next-footer d-flex justify-content-end align-items-center">
                        <button type="button" class="back-button"><i class="fa fa-chevron-left"></i> Back</button>
                        <button type="button" class="btn-next">Next <i class="fa fa-chevron-right"></i></button>
                    </div>
                </fieldset>

                <fieldset class="step hidden" data-step="5">
                    <div class="mb-[25px]">
                        <p><small class="text-red-500">*</small>Registered Agent Service</p>
                        <div class="grid grid-cols-1 lg:grid-cols-1 gap-8 pt-6">
                            <div class="flex flex-wrap">
                                <div>
                                    <label class="howwillthis">
                                        <input type="radio" class="member-type radio" value="provided"
                                            name="registered-agent" id="agent-service" autocomplete="off"
                                            checked>
                                        <span>Use our registered agent service (free for 1 year)</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="howwillthis">
                                        <input type="radio" class="member-type radio" value="own"
                                            name="registered-agent" id="agent-own" autocomplete="off">
                                        <span>Provide my own registered agent</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden input fields -->

                            <div id="agent-info" class="hidden mt-4 grid grid-cols-1 lg:grid-cols-3 gap-8">
                                <div class="col-md-4">
                                    <input type="text" id="registered_agent_name" name="registered_agent_name" placeholder="Registered Agent Name" class="border p-2 w-full ">
                                    <span class="error-message"></span>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="registered_agent_address" placeholder="Registered Agent Address" name="registered_agent_address" class="border p-2 w-full rv-address">
                                    <span class="error-message"></span>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="border p-2 w-full " name="registered_email_address" id="registered_email_address" placeholder="Agent Email">
                                    <span class="error-message"></span>
                                </div>
                            </div>
                    </div>

                    <div class="pt-[25px] border-t-[1px] border-[#E5E5E5]">
                        <p><small class="text-red-500">*</small>Virtual Mailbox Service</p>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-6">
                            <div class="flex flex-wrap">
                                <div>
                                    <label class="howwillthis">
                                        <input type="radio" class="member-type radio" name="mailbox" id="mailbox-service" value="provided" autocomplete="off" checked>
                                        <span>Use our virtual mailbox service</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="howwillthis">
                                        <input type="radio" class="member-type radio" name="mailbox" id="mailbox-own" value="own" autocomplete="off">
                                        <span>Provide my own address</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden input fields -->
                        <div id="mailbox-info" class="hidden mt-4">
                            <input type="text"  placeholder="Alternate mailing address"
                                id="virtual_mailbox_address" class="border p-2 w-full">
                                <span class="error-message"></span>
                        </div>
                    </div>

                    <div class="back-next-footer d-flex justify-content-end align-items-center">
                        <button type="button" class="back-button"><i class="fa fa-chevron-left"></i> Back</button>
                        <button type="button" class="btn-next">Next <i class="fa fa-chevron-right"></i></button>
                    </div>

                </fieldset>


                <fieldset class="step hidden" data-step="6">
                    <div
                        class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-6 border-b-[1px] border-[#E5E5E5] lg:pb-[50px]">

                        <div>
                            <label for="review-state"
                                class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    State
                                </span>
                                <span class="text-gray-400 cursor-pointer" title="Select your state">
                                    <i class="fa-solid fa-circle-info"></i>
                                </span>

                            </label>

                            <select disabled type="" placeholder="LLC" id="rv-state" name="rv-state"
                                class="w-full bg-gray-100 cursor-not-allowed  p-2 border rounded-md">
                                <!-- <option value="">New York</option> -->
                                    <?php foreach ($state_data as $skey => $svalue) { ?>
                                        <option value="<?php echo $svalue->iso_code; ?>"><?php echo $svalue->state_name; ?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </div>

                        <div>
                            <label for="review-company-name"
                                class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    Company type
                                </span>
                                <span class="text-gray-400 cursor-pointer" title="Select your state">
                                    <i class="fa-solid fa-circle-info"></i>
                                </span>

                            </label>


                            <select disabled type="" placeholder="" id="rv-company-type" name="rv-company-type"
                                class="w-full bg-gray-100 cursor-not-allowed  p-2 border rounded-md">
                                    <option value="">Select Company Type</option>
                                    <option value="llc">LLC</option>
                                    <option value="s-corp">S Corporation</option>
                                    <option value="c-corp">C Corporation</option>
                            </select>
                        </div>

                        <div>
                            <label for="review-business-name"
                                class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    Business name
                                </span>
                                <span class="text-gray-400 cursor-pointer" title="Select your state">
                                    <i class="fa-solid fa-circle-info"></i>
                                </span>

                            </label>
                            <input disabled type="text" placeholder="Minecodes Technology" id="rv-business_name"
                                name="rv-business_name" class="w-full p-2 border rounded-md cursor-not-allowed">
                        </div>

                        <div>
                            <label for="review-desinator"
                                class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    Designator
                                </span>
                            </label>
                      
                            <input type="text" class="w-full p-2 border rounded-md cursor-not-allowed" id="rv-designator-select" disabled>
                        </div>


                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-1 gap-8 pt-6  lg:pb-[50px]">
                        <div>
                            <h1 class="subheadline_medium subheadline_medium_fee" >State filing fee : <span
                                    class="heading-color" id="rv-state-fee"><b>$50.00</b></span></h1>
                            <p style="display:none;">your company's legal name : <span id="rv-company-name-id"></span></p>
                        </div>

                        <div class="">
                            <label class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    <small class="text-red-500">*</small>Purpose of the Company (You have 100 characters
                                    left)
                                </span>

                            </label>
                            <textarea disabled id="rv-purpose" name="rv-purpose"
                                class="w-full p-2 border rounded-md "
                                rows="4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias, voluptatibus nostrum! Autem aspernatur eum debitis distinctio alias, quis similique quos, natus harum dolorum omnis, eaque labore architecto perspiciatis nihil ad corrupti veniam atque. Error iusto vero sapiente quo itaque facilis necessitatibus quia officia, ea quis hic ipsa ad enim voluptas.</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-1 border-b-[1px] border-[#E5E5E5] lg:pb-[50px]">
                        <div>
                            <label for="review-state"
                                class="text-sm font-medium text-gray-700 flex items-center justify-between w-full">
                                <span>
                                    How will this LLC be managed?
                                </span>
                                <span class="text-gray-400 cursor-pointer" title="Select your state">
                                    <i class="fa-solid fa-circle-info"></i>
                                </span>

                            </label>

                            <div class="llc-__managed-radio">
                                <div class="howwillthis">
                                    <input type="radio" class="member-type radio" value="member_managed" id="rv-member-managed" disabled>
                                    <span>
                                        Member Managed</span>
                                </div>
                                <div class="howwillthis">
                                    <input type="radio" class="member-type radio" value="manager_managed" id="rv-manager-managed" disabled>
                                    <span>
                                        Manager Managed</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div id="rv-member-shareholder-table" class="mt-40">
                        
                            </div>

                        </div>
                    </div>

                    <div class="pt-[50px]">
                        <div class="mb-[25px]">
                            <p><small class="text-red-500">*</small>Registered Agent Service</p>
                            <div class="grid grid-cols-1 lg:grid-cols-1 gap-8 pt-6">
                                <div class="flex flex-wrap">
                                    <div>
                                        <label class="howwillthis">
                                            <input type="radio" class="member-type radio" id="rv-agent-service" value="provided" name="review-registered-agent"
                                                autocomplete="off" disabled>
                                            <span>Use our registered agent service (free for 1 year)</span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="howwillthis">
                                            <input type="radio" class="member-type radio"  id="rv-agent-own" value="own" name="review-registered-agent"
                                                autocomplete="off" disabled>
                                            <span>Provide my own registered agent</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden input fields -->
                            <div id="rv-agent-conditional-field" class="hidden mt-4 grid grid-cols-1 lg:grid-cols-2 gap-8">

                                <input disabled type="text" id="rv-registered_agent_name" name="agent-name"
                                    placeholder="Registered Agent Name" class="border p-2 w-full">
                                <input type="text" class="border p-2 w-full rv-address" placeholder="Registered Agent Address" id="rv-registered_agent_address" disabled>
                                <input disabled type="text" id="rv-registered_email_address"
                                    placeholder="Registered Agent Address" name="agent-address"
                                    class="border p-2 w-full">
                            </div>
                        </div>

                        <div class="pt-[25px] border-t-[1px] border-[#E5E5E5]">
                            <p><small class="text-red-500">*</small>Virtual Mailbox Service</p>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-6">
                                <div class="flex flex-wrap">
                                    <div>
                                        <label class="howwillthis">
                                            <input type="radio" class="member-type radio" id="rv-mailbox-service" value="provided" name="review-virtual-mailbox"
                                                autocomplete="off" disabled>
                                            <span>Use our virtual mailbox service</span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="howwillthis">
                                            <input type="radio" class="member-type radio" id="rv-mailbox-own" value="own" name="review-virtual-mailbox"
                                                autocomplete="off" disabled>
                                            <span>Provide my own address</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden input fields -->
                            <div id="rv-mailbox-conditional-field" class="hidden mt-4">
                                <input type="text" id="rv-virtual_mailbox_address"
                                    placeholder="Alternate mailing address" name="alternate-mailing-address"
                                    class="border p-2 w-full" disabled>
                            </div>
                        </div>
                    </div>


                    <div class="back-next-footer d-flex justify-content-end align-items-center">
                        <button type="button" class="back-button"><i class="fa fa-chevron-left"></i> Back</button>
                        <button type="button" class="btn-next">Next <i class="fa fa-chevron-right"></i></button>
                    </div>
                </fieldset>

                <!-- pricing field  -->
                <fieldset class="step hidden mt-10" data-step="7">

                    <div class="columnsummaryse">
                        <div class="section__summary package-listing">
                            <div class="plans">

                            <?php foreach ($package_data as $package_value): ?>
                                <div class="pricing-plan-3 cursor-pointer transition-all duration-300 outline-none focus-within:ring-4 focus-within:ring-[var(--primary)] focus-within:scale-105 focus-within:shadow-lg">
                                    <div class="pricing-plan__header">
                                        <h2 class="pricing-plan__title package-name"><?php echo $package_value->package_name; ?></h2>
                                        <?php if ($package_value->monthly_price != "0.00" && $package_value->annual_price != "0.00"): ?>
                                            <div class="price-select">
                                                <select id="pricing-options" onchange="updatePrice()">
                                                    <option value="<?php echo $package_value->monthly_price; ?>" data-text="Per month">Monthly</option>
                                                    <option value="<?php echo $package_value->annual_price; ?>" data-text="Per year">Yearly</option>
                                                </select>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="pricing-plan__price-container">
                                        <h3 class="pricing-plan__price">
                                            <span class="pricing-plan__price-span"></span>
                                            <?php
                                                $payamount = 0;
                                                $packagetype = '';
                                            ?>
                                            <?php if ($package_value->base_price > 0 && $package_value->monthly_price == 0.00 && $package_value->annual_price == 0.00): ?>
                                                <span class="pricing-plan__price-span package-annual-amount" data-amount="<?php echo (int) $package_value->base_price; ?>">
                                                    <?php echo $package_value->currency->currency_symbol . number_format($package_value->base_price, 2); ?>
                                                    <?php $payamount = (int) $package_value->base_price; ?>
                                                </span>
                                            <?php elseif ($package_value->monthly_price > 0): ?>
                                                <span class="pricing-plan__price-span package-annual-amount" data-amount="<?php echo (int) $package_value->monthly_price; ?>">
                                                    <?php echo $package_value->currency->currency_symbol . number_format($package_value->monthly_price, 2); ?>
                                                    <?php 
                                                        $payamount = (int) $package_value->monthly_price;
                                                        $packagetype = 'month';
                                                    ?>
                                                </span>
                                                <span class="pricing-plan__price-span-3">/ Per month</span>
                                            <?php elseif ($package_value->annual_price > 0): ?>
                                                <span class="pricing-plan__price-span package-annual-amount" data-amount="<?php echo (int) $package_value->annual_price; ?>">
                                                    <?php echo $package_value->currency->currency_symbol . number_format($package_value->annual_price, 2); ?>
                                                    <?php 
                                                        $payamount = (int) $package_value->annual_price;
                                                        $packagetype = 'year';
                                                    ?>
                                                </span>
                                                <span class="pricing-plan__price-span-3">/ Per year</span>
                                            <?php endif; ?>
                                        </h3>
                                        <p class="pricing-plan__fee-description">+ State fee</p>
                                    </div>
                                    <button type="button" class="flex justify-center items-center pricing-plan__button package-btn selected-package-price" 
                                        data-package_id="<?php echo $package_value->id; ?>" 
                                        data-amount="<?php echo $payamount; ?>" 
                                        data-package_name="<?php echo $package_value->package_name; ?>" 
                                        data-package_type="<?php echo $packagetype; ?>"  
                                        data-currency_id="<?php echo $package_value->currency_id; ?>" 
                                        data-currency_code="<?php echo $package_value->currency->currency_code; ?>" 
                                        data-currency_symbol="<?php echo $package_value->currency->currency_symbol; ?>">
                                        <img src="https://occams.ai/app/public/user-uploads/app-logo/img_fi3601877.svg" alt="Fi 3601877" class="fi_3601877">
                                        <span>Choose Plan</span>
                                        <img src="https://occams.ai/app/public/user-uploads/app-logo/img_arrowright_20x20.svg" alt="Arrow Right" class="arrow_right">
                                    </button>
                                    <p class="pricing-plan__description-3"><?php echo $package_value->description; ?></p>
                                </div>
                            <?php endforeach; ?>

                            </div>
                        </div>


                        <div class="package-description">
                            <div class="package-description__title">
                                <p class="copy">
                                    Compare packages</p>
                                <div class="package-description__buttons">
                                    <button type="button" class="flex-row-center-center collapsed_all">
                                        Collapsed all </button>
                                    <button type="button" class="flex-row-center-center expand_all">
                                        Expand all</button>
                                </div>
                            </div>
                            <div class="package-description__content">
                                <!-- Accordion Section -->
                                <div class="business-accordian">
                                    <div class="business">
                                        <p class="package-description__content-title">
                                            Business Incorporation</p>
                                        <img src="https://occams.ai/app/public/user-uploads/app-logo/img_close-1.svg"
                                            alt="Fi1828906" class="fi1828906_one">
                                    </div>
                                    <div class="package-description__content-section">
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Identify the optimal structure for the business to be incorporated
                                                    (LLC/C Corp/S Corp/ Non Profit)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Identify the best state for the business to be incorporated in</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Incorporate the business in a jurisdiction as agreed upon</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Registered Agent Services for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Provide virtual US address for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Obtain a Employer Identification number from IRS</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Identify the optimal structure for the business to be incorporated
                                                    (LLC/C Corp/S Corp/ Non Profit)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>Provide Bylaws and Operating Documents
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="cross" class="checkmark_on-cross">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>Complete filing for Corporate Transparency Act
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="cross" class="checkmark_on-cross">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>File Trade name/ DBA with State
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="cross" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>Assist in opening business bank account
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="cross" class="checkmark_on-cross">
                                            </div>
                                        </div>
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Identify the optimal structure for the business to be incorporated
                                                    (LLC/C Corp/S Corp/ Non Profit)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Identify the best state for the business to be incorporated in</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Incorporate the business in a jurisdiction as agreed upon</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Registered Agent Services for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Provide virtual US address for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Obtain a Employer Identification number from IRS</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Identify the optimal structure for the business to be incorporated
                                                    (LLC/C Corp/S Corp/ Non Profit)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>Provide Bylaws and Operating Documents
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>Complete filing for Corporate Transparency Act
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>File Trade name/ DBA with State
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="cross" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>Assist in opening business bank account
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="cross" class="checkmark_on-cross">
                                            </div>
                                        </div>
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Identify the optimal structure for the business to be incorporated
                                                    (LLC/C Corp/S Corp/ Non Profit)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Identify the best state for the business to be incorporated in</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Incorporate the business in a jurisdiction as agreed upon</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Registered Agent Services for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Provide virtual US address for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Obtain a Employer Identification number from IRS</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Identify the optimal structure for the business to be incorporated
                                                    (LLC/C Corp/S Corp/ Non Profit)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>Provide Bylaws and Operating Documents
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>Complete filing for Corporate Transparency Act
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>File Trade name/ DBA with State
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>Assist in opening business bank account
                                                </p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="business-accordian">
                                    <div class="business">
                                        <p class="package-description__content-title">
                                            Annual Reports</p>
                                        <img src="https://occams.ai/app/public/user-uploads/app-logo/img_close-1.svg"
                                            alt="Close" class="fi1828906_one">
                                    </div>
                                    <div class="package-description__content-section">
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Registered Agent Services for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Provide virtual US address for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File State annual reports ( 1 State)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File Alternatete names such as DBA with the applicable state</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File for change in Corporate Structure (eg S Corp to C Corp)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Compliance for change in ownership (stock transfer, IRS change in
                                                    responsible party)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Corporate Transparency Act related compliance</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                        </div>
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Registered Agent Services for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Provide virtual US address for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File State annual reports ( 1 State)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File Alternatete names such as DBA with the applicable state</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File for change in Corporate Structure (eg S Corp to C Corp)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Compliance for change in ownership (stock transfer, IRS change in
                                                    responsible party)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Corporate Transparency Act related compliance</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                        </div>
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Registered Agent Services for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Provide virtual US address for 1 Year</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File State annual reports ( 1 State)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File Alternatete names such as DBA with the applicable state</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File for change in Corporate Structure (eg S Corp to C Corp)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Compliance for change in ownership (stock transfer, IRS change in
                                                    responsible party)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>

                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Corporate Transparency Act related compliance</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="business-accordian">
                                    <div class="business">
                                        <p class="package-description__content-title">
                                            Corporate Tax Filing</p>
                                        <img src="https://occams.ai/app/public/user-uploads/app-logo/img_close-1.svg"
                                            alt="Close" class="fi1828906_one">
                                    </div>
                                    <div class="package-description__content-section">
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File Annual Income Tax Returns for Federal and State (1 State)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                        </div>
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File Annual Income Tax Returns for Federal and State (1 State)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                        </div>
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    File Annual Income Tax Returns for Federal and State (1 State)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="business-accordian">
                                    <div class="business">
                                        <p class="package-description__content-title">
                                            Book-Keeping</p>
                                        <img src="https://occams.ai/app/public/user-uploads/app-logo/img_close-1.svg"
                                            alt="Close" class="fi1828906_one">
                                    </div>
                                    <div class="package-description__content-section">
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Maintain books of accounts for the US entity (Upto 100 bank + cc
                                                    transactions pm)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Bank and Credit Card reconciliation</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Prepare Income Statement, Balance Sheet & Cash Flow</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Accounts receivable/Payable Management</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                        </div>
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Maintain books of accounts for the US entity (Upto 100 bank + cc
                                                    transactions pm)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Bank and Credit Card reconciliation</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Prepare Income Statement, Balance Sheet & Cash Flow</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Accounts receivable/Payable Management</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_cut.svg"
                                                    alt="Checkmark" class="checkmark_on-cross">
                                            </div>
                                        </div>
                                        <div class="business-2">
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Maintain books of accounts for the US entity (Upto 100 bank + cc
                                                    transactions pm)</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Bank and Credit Card reconciliation</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Prepare Income Statement, Balance Sheet & Cash Flow</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                            <div class="package-description__content-section-item">
                                                <p>
                                                    Accounts receivable/Payable Management</p>
                                                <img src="https://occams.ai/app/public/user-uploads/app-logo/img_checkmark_yellow_900.svg"
                                                    alt="Checkmark" class="checkmark_on">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="back-next-footer d-flex justify-content-end align-items-center">
                        <button type="button" class="back-button"><i class="fa fa-chevron-left"></i> Back</button>
                        <button type="button" class="btn-next">Next <i class="fa fa-chevron-right"></i></button>
                    </div>


                </fieldset>

                <fieldset class="step hidden" data-step="8">
                    <h1>Payment</h1>
                    <div class="back-next-footer d-flex justify-content-end align-items-center">
                        <button type="button" class="back-button"><i class="fa fa-chevron-left"></i> Back</button>
                        <button type="submit" name="submit" class="btn-next">Submit <i
                                class="fa fa-chevron-right"></i></button>
                    </div>
                </fieldset>


            </form>
        </div>
    </div>


</section>

<div id="payment-popup" class="modal fade overflow-auto" >
    <div class="modal-dialog justify-content-center align-items-center modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Checkout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="closemodal()">×</button>
            </div>

            <div class="modal-body">
                <form id="payment-form">
                    <div class="row payment-div d-none">
                        <div class="col-sm-12">
                            <div id="address-element">
                                <!-- Address Element will be inserted here -->
                                <p class="loading-text">Processing payment options…</p>
                            </div>
                            <!-- Total Summary Section -->
                            <div id="totla_summery" class="row">
                                <div class="col-md-12">
                                    <div class="product-payment">
                                        <input type="hidden" id="discountprice" value="0">
                                        <input type="hidden" id="finalprice" value="99">
                                        <input type="hidden" id="discount_type" value="percent">
                                        <input type="hidden" id="coupon_id" value="">
                                        <div class="coupon-header">
                                            <h4></h4>
                                            <p><span></span><span id="packagetypes">per entitys*</span> + <span id="statefees"></span></p>
                                        </div>
                                        <label class="payment-card-label">Card Details</label>
                                        <div id="card-element">
                                            <!-- Elements will create input elements here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- We'll put the error messages in this element -->
                            <div id="payment-errors" role="alert"></div>
                            <div id="messages" role="alert" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="loading-view">

                    </div>

                    <div class="d-flex justify-content-center">
                        <button id="pay-button" class="pay-product payment-div d-none">Pay</button>
                        <!-- <button class="close-btn">Close</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>

    function closemodal(){
        document.getElementById("payment-popup").style.display = "none";
    }

    document.addEventListener("DOMContentLoaded", function () {
        let currentStep = 1;
        const totalSteps = document.querySelectorAll(".step").length;
        const progressText = document.getElementById("progress-text");
        const stepTitle = document.getElementById("step-title");

        // Titles for each step
        const stepTitles = {
            1: "Entity step",
            2: "Entity details",
            3: "Entity stakeholders",
            4: "Director/Officer information",
            5: "Add ons",
            6: "Review & proceed",
            7: "Checkout"
        };

        function showStep(step) {

            document.querySelectorAll(".step").forEach((fieldset) => {
                fieldset.classList.add("hidden");
            });

            const activeStep = document.querySelector(`.step[data-step="${step}"]`);
            if (activeStep) activeStep.classList.remove("hidden");

            updateProgress(step);
            updateTitle(step);
        }

        function updateProgress(step) {
            let percentage = ((step - 1) / (totalSteps - 1)) * 100;
            progressText.innerText = `${Math.round(percentage)}% completed`;
        }

        function updateTitle(step) {
            stepTitle.innerText = stepTitles[step] || "Multi-Step Form";
        }

        document.querySelectorAll(".btn-next").forEach((button) => {
            button.addEventListener("click", () => {
                if (validateStep(currentStep)) {
                    if (currentStep < totalSteps) {
                                
                        if (currentStep == 1) {
                            
                            createUpdateCompanyFormation();
                    
                        }else if (currentStep == 2 || currentStep == 3 || currentStep == 4 || currentStep == 5){
                        
                            UpdateCompanyFormationData(currentStep);
                        
                        }
                        currentStep++;

                        if(currentStep == 4 && document.getElementById("company-type").value == 'llc'){
                            currentStep = 5;
                        }

                        showStep(currentStep);
                    }
                }
            });
        });

        document.querySelectorAll(".back-button").forEach((button) => {
            button.addEventListener("click", () => {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });


        
        function validateStep(stepIndex) {
            
            console.log('validstep='+stepIndex);

            let isValid = true;
            if (stepIndex === 1) {
                var state = document.getElementById('state').value;
                var companyType = document.getElementById('company-type').value;
                if (state === '') {
                    isValid = false;
                    console.log('state');
                    document.getElementById('state').classList.add('is-invalid');
                    jQuery('#state').next('.error-message').html('Please select state');
                } else {
                    document.getElementById('state').classList.remove('is-invalid');
                    jQuery('#state').next('.error-message').html('');
                }
                if (companyType === '') {
                    isValid = false;
                    console.log('company type');
                    document.getElementById('company-type').classList.add('is-invalid');
                    jQuery('#company-type').next('.error-message').html('Please select company type');
                } else {
                    document.getElementById('company-type').classList.remove('is-invalid');
                    jQuery('#company-type').next('.error-message').html('');
                }
            } else if (stepIndex == 2) {

                var business_name = document.getElementById('business_name').value.trim();
                var designator = document.getElementById('designator-select').value;

                if (business_name === '') {
                    isValid = false;
                    document.getElementById('business_name').classList.add('is-invalid');
                    jQuery('#business_name').next('.error-message').html('Please enter business name');
                } else if (/\d/.test(business_name)) {
                    isValid = false;
                    document.getElementById('business_name').classList.add('is-invalid');
                    jQuery('#business_name').next('.error-message').html('Business name cannot include numbers');
                } else if (business_name.length < 3 || business_name.length > 100) {
                    isValid = false;
                    document.getElementById('business_name').classList.add('is-invalid');
                    jQuery('#business_name').next('.error-message').html('Business name must be between 3 and 100 characters');
                } else {
                    document.getElementById('business_name').classList.remove('is-invalid');
                    jQuery('#business_name').next('.error-message').html('');
                }
                var purpose = document.getElementById('purpose').value.trim();

                if (purpose !== '') {
                    if (purpose.length > 500) {
                        isValid = false;
                        console.log('purpose');
                        document.getElementById('purpose').classList.add('is-invalid');
                        jQuery('#purpose').next('.error-message').html('Purpose should be less than 500 characters');
                    } else {
                        document.getElementById('purpose').classList.remove('is-invalid');
                        jQuery('#purpose').next('.error-message').html('');
                    }
                } else {

                    document.getElementById('purpose').classList.remove('is-invalid');
                    jQuery('#purpose').next('.error-message').html('');
                }

                if (designator === '') {
                    isValid = false;
                    console.log('designatior');
                    document.getElementById('designator-select').classList.add('is-invalid');
                    jQuery('#designator-select').next('.error-message').html('Please select designator');
                } else {
                    document.getElementById('designator-select').classList.remove('is-invalid');
                    jQuery('#designator-select').next('.error-message').html('');
                }
            } else if (stepIndex == 3) {
                console.log('valid if = '+stepIndex);
                var company_type = $('#company-type').val();
                if(company_type == 'llc'){
                            
                            // var llc_managed_type = $('#member-type').val();
                                var llc_managed_type = $('input[name="member_type"]:checked').val();

                            if (llc_managed_type == "manager_managed") {
                                $("#manager .manager-details__fields").each(function () {
                                    let nameInput = $(this).find('input[name^="manager_name_"]');
                                    let addressInput = $(this).find('input[name^="manager_address_"]');
                                    let sharesInput = $(this).find('input[name^="shareholder_shares_"]');

                                    $(this).find(".error-message").text("");
                                    // Validate Shareholder Name
                                    if ($.trim(nameInput.val()) === "") {
                                        nameInput.closest('.form__input').next('.error-message').html('Manager Name is required.');
                                        isValid = false;
                                        console.log('manager name');
                                    }else{
                                        nameInput.closest('.form__input').next('.error-message').html('');
                                    }
                                    if ($.trim(addressInput.val()) === "") {
                                        addressInput.closest('.form__input').next('.error-message').html('Manager Address is required.');
                                        isValid = false;
                                        console.log('manager address');
                                    }else{
                                        addressInput.closest('.form__input').next('.error-message').html('');
                                    }
                                    if(typeof sharesInput.val() != "undefined"){
                                        if ($.trim(sharesInput.val()) === "") {
                                            sharesInput.closest('.form__input').next('.error-message').html('Ownership % is required.');
                                            isValid = false;
                                            console.log('Manager ownership %');
                                        }else{
                                            sharesInput.closest('.form__input').next('.error-message').html('');
                                        }
                                    }else{
                                        console.log('share input undefined');
                                    }
                                });
                            }

                            $("#member-container .member-profile-form").each(function () {
                                let nameInput = $(this).find('input[name^="member_name_"]');
                                let addressInput = $(this).find('input[name^="member_address_"]');
                                let sharesInput = $(this).find('input[name^="shareholder_shares_"]');
                                
                                // Reset previous errors
                                $(this).find(".error-message").text("");

                                // Validate Shareholder Name
                                if ($.trim(nameInput.val()) === "") {
                                    nameInput.closest('.form__input').next('.error-message').html('Member Name is required.');
                                    isValid = false;
                                    console.log('member name');
                                }else{
                                    nameInput.closest('.form__input').next('.error-message').html('');
                                }

                                // Validate Shareholder Address
                                if ($.trim(addressInput.val()) === "") {
                                    addressInput.closest('.form__input').next('.error-message').html('Member Address is required.');
                                    isValid = false;
                                    console.log('member address');
                                }else{
                                    addressInput.closest('.form__input').next('.error-message').html('');
                                    // console.log('4444444');
                                }

                                // Validate Number of Shares
                                if ($.trim(sharesInput.val()) === "" || parseInt(sharesInput.val()) < 1) {
                                    // console.log('5555555');
                                    sharesInput.closest('.form__input').next('.error-message').html('Ownership % is required.');
                                    isValid = false;
                                    console.log('owner percentage');
                                }else{
                                    // console.log('666666');
                                    sharesInput.closest('.form__input').next('.error-message').html('');
                                }

                            });                    

                             var ow_num = 0;
                            document.querySelectorAll('.ownership_percentage_value').forEach(function(input) {
                                if (input.value != '') {
                                    ow_num += parseInt(input.value);
                                }
                            });
                            if (ow_num > 100 || ow_num == 0) {
                                isValid = false;
                                $('.ownership_percentage_value').addClass('is-invalid');
                                $('.ownership_percentage_value').closest('.form__input').next('.error-message').html('Total ownership should be equal to 100%');
                            } else {
                                $('.ownership_percentage_value').removeClass('is-invalid');
                                $('.ownership_percentage_value').closest('.form__input').next('.error-message').html('');
                            }

                }else{
                    // console.log('777777777');
                    var shares_authorized = document.getElementById('shares-authorized').value;
                    var par_value = document.getElementById('par-value').value;

                    if (shares_authorized.length==0){
                        console.log('false');
                            isValid = false;
                            console.log('share authorized');
                            document.getElementById('shares-authorized').classList.add('is-invalid');
                            jQuery('#shares-authorized').next('.error-message').html('Shares authorized is required.');
                    }else{
                            document.getElementById('shares-authorized').classList.remove('is-invalid');
                            jQuery('#shares-authorized').next('.error-message').html('');
                    }                    
                        if(par_value.length==0){
                            isValid = false;
                            console.log('par value');
                            document.getElementById('par-value').classList.add('is-invalid');
                            jQuery('#par-value').next('.error-message').html('Per value is required.');
                        }else{
                            document.getElementById('par-value').classList.remove('is-invalid');
                            jQuery('#par-value').next('.error-message').html('');
                        }

                            $("#shareholder-container .shareholder-profile-form").each(function () {
                                let nameInput = $(this).find('input[name^="shareholder_name_"]');
                                let addressInput = $(this).find('input[name^="shareholder_address_"]');
                                let sharesInput = $(this).find('input[name^="shareholder_shares_"]');
                                let directorSelect = $(this).find('select[name^="shareholder_director_"]');

                                // Reset previous errors
                                $(this).find(".error-message").text("");

                                // Validate Shareholder Name
                                if ($.trim(nameInput.val()) === "") {
                                    nameInput.closest('.form__input').next('.error-message').html('Shareholder Name is required.');
                                    isValid = false;
                                    console.log('share holder name');
                                }else{
                                    nameInput.closest('.form__input').next('.error-message').html('');
                                }

                                // Validate Shareholder Address
                                if ($.trim(addressInput.val()) === "") {
                                    addressInput.closest('.form__input').next('.error-message').html('Shareholder Address is required.');
                                    isValid = false;
                                    console.log('share holder address');
                                }else{
                                    addressInput.closest('.form__input').next('.error-message').html('');
                                }

                                // Validate Number of Shares
                                if ($.trim(sharesInput.val()) === "" || parseInt(sharesInput.val()) < 1) {
                                    sharesInput.closest('.form__input').next('.error-message').html('Enter a valid number of shares.');
                                    isValid = false;
                                    console.log('share holder shares');
                                }else{
                                    sharesInput.closest('.form__input').next('.error-message').html('');
                                }

                                // Validate Director/Officer Selection
                                if (directorSelect.val() === "") {
                                    directorSelect.next(".error-message").text("Please select a role.");
                                    // directorSelect.closest('.form__input').next('.error-message').html('Please select a role.');
                                    isValid = false;
                                    console.log('share role');
                                }else{
                                    directorSelect.next(".error-message").text("");
                                }
                            });

                            var share_num = 0;
                            var shares_authorized = parseInt(jQuery('#shares-authorized').val());

                            document.querySelectorAll('.shares_num').forEach(function(input) {
                                    if (input.value != '') {
                                        share_num += parseInt(input.value);
                                    }
                            });
                            
                            if (share_num < parseInt(shares_authorized)) {
                                    isValid = false;
                                    console.log('shareholder less than');       
                                    $('#shares-authorized').next('.error-message').html('Total Share Owned should be equal to Number of Shares Authorized.');

                            }

                }
                // console.log('909090909090');
            } else if (stepIndex == 5) {
                var registered_agent = document.querySelector('input[name="registered-agent"]:checked').value;
                var mailbox = document.querySelector('input[name="mailbox"]:checked').value;
                var registered_agent_email = document.querySelector('input[name="mailbox"]:checked').value;

                if (registered_agent === 'own') {
                    var registered_agent_name = document.getElementById('registered_agent_name').value;
                    var registered_agent_address = document.getElementById('registered_agent_address').value;
                    var registered_email_address = document.getElementById('registered_email_address').value;


                    if (registered_agent_name === '') {
                        isValid = false;
                        document.getElementById('registered_agent_name').classList.add('is-invalid');
                        jQuery('#registered_agent_name').next('.error-message').html('Please enter registered agent name');
                    } else {
                        document.getElementById('registered_agent_name').classList.remove('is-invalid');
                        jQuery('#registered_agent_name').next('.error-message').html('');
                    }

                    if (registered_agent_address === '') {
                        isValid = false;
                        document.getElementById('registered_agent_address').classList.add('is-invalid');
                        jQuery('#registered_agent_address').next('.error-message').html('Please enter registered agent address');
                    } else {
                        document.getElementById('registered_agent_address').classList.remove('is-invalid');
                        jQuery('#registered_agent_address').next('.error-message').html('');
                    }
                    if (registered_email_address === '') {
                        isValid = false;
                        document.getElementById('registered_email_address').classList.add('is-invalid');
                        jQuery('#registered_email_address').next('.error-message').html('Please enter agent email address');
                    } else {
                        var email_pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                        if (!email_pattern.test(registered_email_address)) {
                            isValid = false;
                            document.getElementById('registered_email_address').classList.add('is-invalid');
                            jQuery('#registered_email_address').next('.error-message').html('Please enter valid email address');
                        }else{
                            document.getElementById('registered_email_address').classList.remove('is-invalid');
                            jQuery('#registered_email_address').next('.error-message').html('');
                        }
                    }
                }

                if (mailbox === 'own') {
                    var virtual_mailbox_address = document.getElementById('virtual_mailbox_address').value;
                    var email_pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

                    if (virtual_mailbox_address === '') {
                        isValid = false;
                        document.getElementById('virtual_mailbox_address').classList.add('is-invalid');
                        jQuery('#virtual_mailbox_address').next('.error-message').html('Please enter virtual mailbox address');
                    } else if (!email_pattern.test(virtual_mailbox_address)) {
                        isValid = false;
                        document.getElementById('virtual_mailbox_address').classList.add('is-invalid');
                        jQuery('#virtual_mailbox_address').next('.error-message').html('Please enter valid email address');
                    } else {
                        document.getElementById('virtual_mailbox_address').classList.remove('is-invalid');
                        jQuery('#virtual_mailbox_address').next('.error-message').html('');
                    }
                }
            }else if (stepIndex == 4) {
                
                            $("#director-container .member-profile-form").each(function () {
                                let director_name = $(this).find('input[name^="director_name_"]');
                                let director_address = $(this).find('input[name^="director_address_"]');
                                
                                // Reset previous errors
                                $(this).find(".error-message").text("");

                                // Validate Shareholder Name
                                if ($.trim(director_name.val()) === "") {
                                    director_name.closest('.form__input').next('.error-message').html('Director Name is required.');
                                    isValid = false;
                                }else{
                                    director_name.closest('.form__input').next('.error-message').html('');
                                }

                                // Validate Shareholder Address
                                if ($.trim(director_address.val()) === "") {
                                    director_address.closest('.form__input').next('.error-message').html('Director Address is required.');
                                    isValid = false;
                                }else{
                                    director_address.closest('.form__input').next('.error-message').html('');
                                }
                            });

                            var president_ceo_name = $('#president_ceo_name').val();
                            var president_ceo_address = $('#president_ceo_address').val();
                             var treasurer_cfo_name = $('#treasurer_cfo_name').val();
                            var treasurer_cfo_address = $('#treasurer_cfo_address').val();
                            var secretary_name = $('#secretary_name').val();
                            var secretary_address = $('#secretary_address').val();                    
                            
                            $('#president_ceo_name').closest('.form__input').next('.error-message').html('');
                            $('#president_ceo_address').closest('.form__input').next('.error-message').html('');
                            $('#treasurer_cfo_name').closest('.form__input').next('.error-message').html('');
                            $('#treasurer_cfo_address').closest('.form__input').next('.error-message').html('');
                            $('#secretary_name').closest('.form__input').next('.error-message').html('');
                            $('#secretary_address').closest('.form__input').next('.error-message').html('');

                            if(president_ceo_name.length==0){
                                isValid = false;
                                $('#president_ceo_name').closest('.form__input').next('.error-message').html('President/CEO Name is required.');
                            }
                            if(president_ceo_address.length==0){
                                isValid = false;
                                $('#president_ceo_address').closest('.form__input').next('.error-message').html('President/CEO Address is required.');
                            }
                            if(treasurer_cfo_name.length==0){
                                isValid = false;
                                $('#treasurer_cfo_name').closest('.form__input').next('.error-message').html('Treasurer/CFO Name is required.');
                            }
                            if(treasurer_cfo_address.length==0){
                                isValid = false;
                                $('#treasurer_cfo_address').closest('.form__input').next('.error-message').html('Treasurer/CFO Address is required.');
                            }
                            if(secretary_name.length==0){
                                isValid = false;
                                $('#secretary_name').closest('.form__input').next('.error-message').html('Secretary Name is required.');
                            }
                            if(secretary_address.length==0){
                                isValid = false;
                                $('#secretary_address').closest('.form__input').next('.error-message').html('Secretary Address is required.');
                            }    
            }
            // isValid = true;
            console.log('isValid='+isValid);
            return isValid;

        }
       

        showStep(currentStep);
    });
</script> 



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const accordions = document.querySelectorAll('.business-accordian');
        const expandAllBtn = document.querySelector('.expand_all');
        const collapseAllBtn = document.querySelector('.collapsed_all');

        let expandAllActive = false; // flag to track expand all mode

        function expandAccordion(accordion) {
            const content = accordion.querySelector('.package-description__content-section');
            const icon = accordion.querySelector('.fi1828906_one');
            accordion.classList.add('active');
            content.style.display = 'flex';
            icon.src = "https://occams.ai/app/public/user-uploads/app-logo/img_fi_1828907.svg"; // minus icon
        }

        function collapseAccordion(accordion) {
            const content = accordion.querySelector('.package-description__content-section');
            const icon = accordion.querySelector('.fi1828906_one');
            accordion.classList.remove('active');
            content.style.display = 'none';
            icon.src = "https://occams.ai/app/public/user-uploads/app-logo/img_close-1.svg"; // plus icon
        }

        function toggleAccordion(accordion) {
            const isActive = accordion.classList.contains('active');
            if (isActive) {
                collapseAccordion(accordion);
            } else {
                expandAccordion(accordion);
            }
        }

        // Initial setup
        accordions.forEach((accordion, index) => {
            if (index === 0) expandAccordion(accordion);
            else collapseAccordion(accordion);

            const header = accordion.querySelector('.business');
            header.addEventListener('click', () => {
                const isActive = accordion.classList.contains('active');

                if (expandAllActive) {
                    // In expand-all mode, just toggle this one only
                    toggleAccordion(accordion);
                } else {
                    // Collapse all others first
                    accordions.forEach(collapseAccordion);
                    expandAccordion(accordion);
                }
            });
        });

        expandAllBtn.addEventListener('click', (e) => {
            e.preventDefault();
            expandAllActive = true;
            accordions.forEach(expandAccordion);
        });

        collapseAllBtn.addEventListener('click', (e) => {
            e.preventDefault();
            expandAllActive = false;
            accordions.forEach(collapseAccordion);
        });
    });
</script>

<script>
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.getAttribute('data-tab');

            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            contents.forEach(c => c.classList.remove('active'));
            document.getElementById(target).classList.add('active');
        });
    });
</script>



<script>


    document.addEventListener("DOMContentLoaded", function () {
        const memberRadio = document.getElementById("member-id");
        const managerRadio = document.getElementById("manager-id");
        const memberSection = document.querySelector(".member-section");
        const managerSection = document.querySelector(".manager-section");

        function toggleSections() {
            if (memberRadio.checked) {
                memberSection.style.display = "block";
                managerSection.style.display = "none";
                memberSection.classList.add("active");
            } else if (managerRadio.checked) {
                // memberSection.style.display = "none";
                managerSection.style.display = "block";
                managerSection.classList.add("active");
                memberSection.classList.remove("active");
            }
        }

        // Add event listeners to both radio buttons
        memberRadio.addEventListener("change", toggleSections);
        managerRadio.addEventListener("change", toggleSections);

        // Initialize on page load
        toggleSections();
    });

</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        function updateButtons() {
            let managerTab = document.getElementById("manager");
            let memberTab = document.getElementById("member");

            let managerButton = document.getElementById("manager-button");
            let memberButton = document.getElementById("member-button");

            if (managerTab.classList.contains("active")) {
                managerButton.style.display = "block";
                memberButton.style.display = "none";
            } else if (memberTab.classList.contains("active")) {
                managerButton.style.display = "none";
                memberButton.style.display = "block";
            }
        }

        // Initial setup
        updateButtons();

        // Listen for changes in active tab (assuming tabs have buttons or navigation)
        document.querySelectorAll("[data-tab]").forEach(tabBtn => {
            tabBtn.addEventListener("click", function () {
                let target = this.getAttribute("data-tab");

                // Remove active class from all tabs
                document.querySelectorAll(".tab-content").forEach(t => t.classList.remove("active"));

                // Add active class to the targeted tab
                document.getElementById(target).classList.add("active");

                // Update button visibility
                updateButtons();
            });
        });
    });

</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function updateButtons() {
            let officerTab = document.getElementById("officer-information");
            let directorButton = document.getElementById("director-button");

            if (officerTab.classList.contains("active")) {
                directorButton.style.display = "none"; // Hide the director button
            } else {
                directorButton.style.display = "block"; // Show it when another tab is active
            }
        }

        // Initial setup
        updateButtons();

        // Listen for tab changes
        document.querySelectorAll("[data-tab]").forEach(tabBtn => {
            tabBtn.addEventListener("click", function () {
                let target = this.getAttribute("data-tab");

                // Remove active class from all tabs
                document.querySelectorAll(".tab-content").forEach(t => t.classList.remove("active"));

                // Add active class to the targeted tab
                document.getElementById(target).classList.add("active");

                // Update button visibility
                updateButtons();
            });
        });
    });

</script>

<script>
    let currentStep = 0;
    const stepTitles = [
        "Step 1: Basic Information",
        "Step 2: Contact Details",
        "Step 3: Address Information",
        "Step 4: Preferences",
        "Step 5: Verification",
        "Step 6: Review",
        "Step 7: Confirmation"
    ];

    function changeStep(n) {
        const steps = document.querySelectorAll(".step");
        steps[currentStep].classList.remove("active");

        currentStep += n;
        if (currentStep < 0) currentStep = 0;
        if (currentStep >= steps.length) currentStep = steps.length - 1;

        steps[currentStep].classList.add("active");
        document.getElementById("step-title").textContent = stepTitles[currentStep];
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Elements for Registered Agent Service
        const provideOwnAgent = document.getElementById("provide-own-agent");
        const useRegisteredAgent = document.getElementById("use-registered-agent");
        const agentInfo = document.getElementById("agent-info");

        // Elements for Virtual Mailbox Service
        const provideOwnAddress = document.getElementById("provide-own-address");
        const useVirtualMailbox = document.getElementById("use-virtual-mailbox");
        const mailboxInfo = document.getElementById("mailbox-info");

        // Show/hide registered agent input fields
        provideOwnAgent.addEventListener("change", function () {
            agentInfo.classList.remove("hidden");
        });
        useRegisteredAgent.addEventListener("change", function () {
            agentInfo.classList.add("hidden");
        });

        // Show/hide virtual mailbox input fields
        provideOwnAddress.addEventListener("change", function () {
            mailboxInfo.classList.remove("hidden");
        });
        useVirtualMailbox.addEventListener("change", function () {
            mailboxInfo.classList.add("hidden");
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Elements for Registered Agent Service
        const reviewProvideOwnAgent = document.getElementById("review-provide-own-agent");
        const reviewUseRegisteredAgent = document.getElementById("review-use-registered-agent");
        const reviewAgentInfo = document.getElementById("review-agent-info");
        const reviewAgentName = document.getElementById("review-agent-name");
        const reviewAgentAddress = document.getElementById("review-agent-address");

        // Elements for Virtual Mailbox Service
        const reviewProvideOwnAddress = document.getElementById("review-provide-own-address");
        const reviewUseVirtualMailbox = document.getElementById("review-use-virtual-mailbox");
        const reviewMailboxInfo = document.getElementById("review-mailbox-info");
        const reviewAlternateMailingAddress = document.getElementById("review-alternate-mailing-address");

        // Function to toggle Registered Agent fields
        function toggleRegisteredAgentFields() {
            if (reviewProvideOwnAgent.checked) {
                reviewAgentInfo.classList.remove("hidden");
                reviewAgentName.removeAttribute("disabled");
                reviewAgentAddress.removeAttribute("disabled");
            } else {
                reviewAgentInfo.classList.add("hidden");
                reviewAgentName.setAttribute("disabled", "true");
                reviewAgentAddress.setAttribute("disabled", "true");
            }
        }

        // Function to toggle Virtual Mailbox fields
        function toggleVirtualMailboxFields() {
            if (reviewProvideOwnAddress.checked) {
                reviewMailboxInfo.classList.remove("hidden");
                reviewAlternateMailingAddress.removeAttribute("disabled");
            } else {
                reviewMailboxInfo.classList.add("hidden");
                reviewAlternateMailingAddress.setAttribute("disabled", "true");
            }
        }

        // Event Listeners
        reviewProvideOwnAgent.addEventListener("change", toggleRegisteredAgentFields);
        reviewUseRegisteredAgent.addEventListener("change", toggleRegisteredAgentFields);

        reviewProvideOwnAddress.addEventListener("change", toggleVirtualMailboxFields);
        reviewUseVirtualMailbox.addEventListener("change", toggleVirtualMailboxFields);

        // Initial Check on Page Load
        toggleRegisteredAgentFields();
        toggleVirtualMailboxFields();
    });
</script>

<script>
    function updatePrice() {
        const selectElement = document.getElementById("pricing-options");
        const selectedOption = selectElement.options[selectElement.selectedIndex];

        const priceAmount = document.getElementById("price-amount");
        const priceDuration = document.getElementById("price-duration");

        // Update the price amount
        priceAmount.textContent = parseFloat(selectedOption.value).toLocaleString();

        // Update the price duration
        priceDuration.textContent = selectedOption.getAttribute("data-text");
    }
</script>



<script type="text/javascript">
    // on change company type
    $(document).on('change', '#company-type', function() {
        var company_type = $(this).val();
        getStateFee();
        var designator_html = '';

        if (company_type == 'llc') {
            $('#llc-shares-structure').show();
            $('#s-c-corp-shares-structure').hide();
            $('#directors-nav-item').hide();
            $('#add-member-footer-btn').addClass('mt-0');
            $('.add-member-footer-btn').css('visibility','visible');
            $('.llc_fields_container').show();
            $('.corporation_fields_container').hide();
            designator_html = '<option value="">Select designator</option><option value="LLC">LLC</option><option value="Limited Liability Company">Limited Liability Company</option>,<option value="L.L.C.">L.L.C.</option>';
        } else if (company_type == 's-corp' || company_type == 'c-corp') {
            $('#llc-shares-structure').hide();
            $('#add-member-footer-btn').removeClass('mt-0');
            $('#s-c-corp-shares-structure').show();
            $('#directors-nav-item').show();
            $('.add-member-footer-btn').css('visibility','hidden');
            $('.llc_fields_container').hide();
            $('.corporation_fields_container').show();
            designator_html = '<option value="">Select designator</option><option value="Inc.">Inc.</option><option value="Incorporated">Incorporated</option>,<option value="Corp.">Corp.</option><option value="Corporation">Corporation</option>';
        }

        $('.designator-select').html(designator_html);
    });

    
    $(document).on('change', '#designator-select', function() {
        var designator = $(this).val();
        var business_name = $("#business_name").val();

        if (business_name.includes('-')) {
            business_name = business_name.replace(/-.*$/, '');
            business_name = business_name.replace(/\s+$/, '');
        }

        if (business_name != '') {
            $("#company-name-id").val(business_name + ' - ' + designator);
        } else {
            $("#company-name-id").val(business_name);
        }
    });

    
    $(document).on('input', '#business_name', function() {
        var designator = $("#designator-select").val();
        var business_name = $(this).val().trim();

        if (business_name.includes('-')) {
            business_name = business_name.replace(/-.*$/, '');
            business_name = business_name.replace(/\s+$/, '');
        }

        if (/\d/.test(business_name)) {
            $(this).addClass('is-invalid');
            $(this).next('.error-message').html('Business name cannot include numbers');
        } else if (business_name.length < 3 || business_name.length > 100) {
            $(this).addClass('is-invalid');
            $(this).next('.error-message').html('Business name must be between 3 and 100 characters');
        } else {

            $(this).removeClass('is-invalid');
            $(this).next('.error-message').html('');
        }

        if (designator !== '' && designator !== null) {
            $("#company-name-id").val(business_name + ' - ' + designator);
        } else {
            $("#company-name-id").val(business_name);
        }
    });

    $(document).on('input', '#purpose', function() {
        var purpose = $(this).val().trim();

        if (purpose !== '') {
            if (purpose.length > 500) {
                $(this).addClass('is-invalid');
                $(this).next('.error-message').html('Purpose should be less than 500 characters');
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.error-message').html('');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.error-message').html('');
        }
    });


    function getStateFee() {
        var state = $('#state').val();
        var company_type = $('#company-type').val();
        var state_fee = 0;
        if (state && company_type) {
            var state_data = <?php echo json_encode($state_data);  ?>;
            $(state_data).each(function(index, element) {
                if (state == element.iso_code) {
                    if (company_type == 'llc') {
                        state_fee = element.llc_formation_fee_mail;
                    } else {
                        state_fee = element.corporation_formation_fee;
                    }
                }
            });
        }
        // $('#state-fee').html('State Filing Fee : <b>$' + state_fee + '.00</b>');
        $('.subheadline_medium_fee').html('State filing fee : <span class="heading-color"><b>$' + state_fee + '.00</b></span>');
        $('#state-fee-id').val(parseFloat(state_fee).toFixed(2));
        $('.pricing-plan__fee-description').html('+<b>$' + state_fee + '.00</b> (State Filing Fee)');
    }


 // ---- create Company formation ------
 function createUpdateCompanyFormation() {
        // return true;
        var state_id_val = $('#state').val();
        var company_type_val = $('#company-type').val();
        var state_fee_val = $('#state-fee-id').val();
        var company_formation_id = $('#company_formation_id').val();
        var user_id = $('#current_user_id').val();

        const formData = {
            state_id: state_id_val,
            company_type: company_type_val,
            state_fee: state_fee_val,
            client_id: user_id,
            completed_step: 1,
            company_formation_id: company_formation_id,
            user_id: user_id,
        };

        $.ajax({
            url: "https://occams.ai/app/public/api/company-signup",
            // url: "{{ Route('api.company-signup') }}",
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {

                if (response.status === 'success') {
                    var company_formation_id = $('#company_formation_id').val(response.company_formation_id);
                } else {

                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.message;
                if (errors) {
                    $('#error-message').html(errors).show();
                } else {
                    errors = "Opps! Something went wrong, Please try again.";
                    $('#error-message').html(errors).show();
                }

            }
        });
        
    }

      // Update company formation data
      function UpdateCompanyFormationData(step) {
        
        var api_url = "https://occams.ai/app/public/api/update-company-data";

        var company_formation_id = $('#company_formation_id').val();
        var company_type = $('#company-type').val();
        var api_call = 0;
        if (step == 2) {
            var business_name_val = $('#business_name').val();
            var designator_val = $('#designator-select').val();
            var purpose_val = $('#purpose').val();
            // var company_name = $('#company-name-id').text().trim();
            var company_name = $('#company-name-id').val();

            var formData = {
                business_name: company_name,
                designator: designator_val,
                purpose_of_company: purpose_val,
                completed_step: 2,
                company_formation_id: company_formation_id,
            };
            api_call = 1;
        } else if (step == 3) {
                

            if(company_type=='llc'){  
                       var llc_managed_type = $('input[name="member_type"]:checked').val();
                       var total_ownership = 0;

                       if (llc_managed_type === 'member_managed') {
                           total_ownership = document.querySelectorAll('#member-container .member-profile-form').length;
                           updateOwnerData('members', llc_managed_type);
                       } else if (llc_managed_type === 'manager_managed') {
                           total_ownership_manager = document.querySelectorAll('#manager .manager-details__fields').length;
                           total_ownership_member =  document.querySelectorAll('#member-container .member-profile-form').length;
                           total_ownership = total_ownership_manager + total_ownership_member;

                           updateOwnerData('managers', llc_managed_type);
                        //    updateOwnerData('members', llc_managed_type);
                       }

                       var formData = {
                           llc_managed_type: llc_managed_type,
                           number_of_shares_authorized: '',
                           shares_par_value: '',
                           total_ownership: total_ownership,
                           completed_step: 4,
                           company_formation_id: company_formation_id,
                       };
                       api_call = 1;
            }else {

                 // shareholder create
                var shares_authorized_val = $('#shares-authorized').val();
                var par_value = $('#par-value').val();
                var total_ownership = document.querySelectorAll('#shareholder-container .shareholder-profile-form').length;

                var formData = {
                    number_of_shares_authorized: shares_authorized_val,
                    shares_par_value: par_value,
                    total_ownership: total_ownership,
                    completed_step: 3,
                    company_formation_id: company_formation_id,
                    member_type: '',
                };
                api_call = 1;
                updateOwnerData('shareholder','');

            }
            
            
        } else if (step == 4) {

            if(company_type !='llc'){  
                
                UpdateCompanyDirectorOfficerData();
            }
        }else if(step == 5){

            var registered_agent_type = $('input[name="registered-agent"]:checked').val();
            var virtual_mailbox_type = $('input[name="mailbox"]:checked').val();
            var registered_agent_name = '';
            var registered_agent_address = '';
            var virtual_mailbox_address = '';

            if (registered_agent_type == "own") {
                registered_agent_name = $('#registered_agent_name').val();
                registered_agent_address = $('#registered_agent_address').val();
                registered_email_address = $('#registered_email_address').val();
            }

            if (virtual_mailbox_type == "own") {
                virtual_mailbox_address = $('#virtual_mailbox_address').val();
            }

            var formData = {
                registered_agent_type: registered_agent_type,
                virtual_mailbox_type: virtual_mailbox_type,
                registered_agent_name: registered_agent_name,
                registered_agent_address: registered_agent_address,
                registered_email_address:registered_email_address,
                virtual_mailbox_address: virtual_mailbox_address,
                completed_step: 5,
                company_formation_id: company_formation_id,
            };
            api_call = 1;
        }

      if(api_call == 1){
        $.ajax({
            url: api_url,
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                if (step == 5) {
                    getCompanyFormationData();
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.message;
                if (errors) {
                    $('#error-message').html(errors).show();
                } else {
                    errors = "Opps! Something went wrong, Please try again.";
                    $('#error-message').html(errors).show();
                }

            }
        });
      }
    }

    
    function updateOwnerData(owner_type,llc_managed_type) {
            
            var shareholders = [];
            var shareholders_datas = [];
            var company_formation_id = $('#company_formation_id').val();

        if (owner_type == 'shareholder') {
            var $share_ownr_val = 'shares_owned';
            var $other_share_ownr_val = 'ownership_percentage';
            var member_container = '#shareholder-container .shareholder-profile-form';
            $(member_container).each(function() {
                shareholders['stakeholder_id'] = $(this).find('input[name^="owner_id_"]').val();
                shareholders['name'] = $(this).find('input[name^="shareholder_name_"]').val();
                shareholders['address'] = $(this).find('input[name^="shareholder_address_"]').val();
                shareholders['no_of_shares'] = $(this).find('input[name^="shareholder_shares_"]').val();
                shareholders['is_director'] = 0;
                shareholders['is_president_ceo'] = 0;
                shareholders['is_secretary'] = 0;
                shareholders['is_treasurer_cfo'] = 0;
                shareholders['is_shareholder'] = 1;
                var share_name = $(this).find('input[name^="shareholder_name_"]').val();
                var share_address = $(this).find('input[name^="shareholder_address_"]').val();

                var shareholder_director = $(this).find('select[name^="shareholder_director_"]').val();
                
                if(shareholder_director =='Director'){
                    shareholders['is_director'] = 1;
                }else if(shareholder_director =='President/CEO'){
                    shareholders['is_president_ceo'] = 1;
                    $('#president_ceo_name').val(share_name);//.prop('disabled',true);
                    $('#president_ceo_address').val(share_address);//.prop('disabled',true);
                }else if(shareholder_director =='Secretary'){
                    shareholders['is_secretary'] = 1;    
                    $('#secretary_name').val(share_name);//.prop('disabled',true);
                    $('#secretary_address').val(share_address);//.prop('disabled',true);
                }else if(shareholder_director =='TReasurer/CFO'){
                    shareholders['is_treasurer_cfo'] = 1;
                    $('#treasurer_cfo_name').val(share_name);//.prop('disabled',true);
                    $('#treasurer_cfo_address').val(share_address);//.prop('disabled',true);
                }

                var shareholders_data = Object.assign({}, shareholders);
                shareholders_datas.push(shareholders_data);
            });

            company_formation_id = company_formation_id;
            var deleted_shareholder_id = $('#deleted_shareholder_id').val();
            // var api_url = "{{ Route('api.submit-stakeholders-data') }}";
            var api_url = "https://occams.ai/app/public/api/submit-stakeholders-data";
            

            var formData = {
                company_formation_id: company_formation_id,
                deleted_id:deleted_shareholder_id,
                stakeholder_data: shareholders_datas
            };
            
            $.ajax({
                url: api_url,
                method: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function(response) {
                        getAndShowDirectorOfficer(company_formation_id);
                        $(member_container).each(function(sindex,selement) {
                            $(this).find('input[name^="owner_id_"]').val(response.stakeholder_id[sindex].stakeholder_id);
                        });
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.message;
                    if (errors) {
                        $('#error-message').html(errors).show();
                    } else {
                        errors = "Opps! Something went wrong, Please try again.";
                        $('#error-message').html(errors).show();
                    }
                }
            });

        } else {
            var llc_managed_type = $('input[name="member_type"]:checked').val();
            UpdateCompanyManagerData(llc_managed_type);
        }
    }

    function getAndShowDirectorOfficer(company_formation_id){
                        
            $('#president_ceo_id').val('');
            $('#president_ceo_name').val('');
            $('#president_ceo_address').val('');
            $('#treasurer_cfo_id').val('');
            $('#treasurer_cfo_name').val('');
            $('#treasurer_cfo_address').val('');
            $('#secretary_id').val('');
            $('#secretary_name').val('');
            $('#secretary_address').val('');

        // var api_url = "{{ Route('api.director-officers-data') }}";
        var api_url = "https://occams.ai/app/public/api/director-officers-data";
       
        
        var director_container = '#director-container';

        var formData = {
            company_formation_id: company_formation_id,
        };
        
        $.ajax({
            url: api_url,
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(shareResponse) {
                console.log(shareResponse);
                $(director_container).empty();
                var noCount=1;
                $(shareResponse.stakeholder_id).each(function(dnindex,delement) {
                    if(delement.is_director){
                        $(director_container).append(`
                            <div class="flex flex-wrap justify-between gap-4 items-center mt-4 member-profile-form">
                                <div class="w-[15%]">
                                    <div class="form__member-row">
                                        <div class="form__member-counter-container">
                                            <p class="header__profile-name">Director ${noCount}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-[30%]">
                                    <div class="form__field-2">
                                        <label class="form__label">Director Name</label>
                                        <input type="hidden" name="director_id_${noCount}" id="director_id_${noCount}" value="${delement.id}">
                                        <div class="form__input">
                                            <input name="director_name_${noCount}" type="text" autocomplete="off" value="${delement.name}">
                                        </div>
                                        <span class="error-message"></span>
                                    </div>
                                </div>
                                <div class="w-[45%]">
                                    <div class="form__field-2">
                                        <label class="form__label">Director Address</label>
                                        <div class="form__input">
                                            <input name="director_address_${noCount}" type="text" autocomplete="off" value="${delement.address}" class="rv-address">
                                        </div>
                                        <span class="error-message"></span>
                                    </div>
                                </div>
                                <div class="w-[5%] flex justify-center items-center">
                                    <img src="https://occams.ai/assets/images/images/delete-red.svg" alt="delete" title="Remove" class="cursor-pointer" onclick="removeMember(this, 'director')">
                                </div>
                            </div>
                        `);
                        $(this).find('input[name^="director_id_"]').val(delement.id);
                        $(this).find('input[name^="director_name_"]').val(delement.name);
                        $(this).find('input[name^="director_address_"]').val(delement.address);
                        noCount++;
                    } else if(delement.is_president_ceo){
                        $('#president_ceo_id').val(delement.id);
                        $('#president_ceo_name').val(delement.name);
                        $('#president_ceo_address').val(delement.address);
                    }else if(delement.is_treasurer_cfo){
                        $('#treasurer_cfo_id').val(delement.id);
                        $('#treasurer_cfo_name').val(delement.name);
                        $('#treasurer_cfo_address').val(delement.address);
                    }else if(delement.is_secretary){
                        $('#secretary_id').val(delement.id);
                        $('#secretary_name').val(delement.name);
                        $('#secretary_address').val(delement.address);
                    }
                });
            }
            });    
    }

    function UpdateCompanyDirectorOfficerData(){
        
             var member_container = '#director-container .member-profile-form';
             var shareholders = [];
             var shareholders_datas = [];

            $(member_container).each(function() {
                shareholders['name'] = $(this).find('input[name^="director_name_"]').val();
                shareholders['address'] = $(this).find('input[name^="director_address_"]').val();
                shareholders['stakeholder_id'] = $(this).find('input[name^="director_id_"]').val();
                shareholders['is_director'] = 1;
                var shareholders_data = Object.assign({}, shareholders);
                shareholders_datas.push(shareholders_data);
            });
        

            var company_formation_id = $('#company_formation_id').val();
            var president_ceo_name = $('#president_ceo_name').val();
            var president_ceo_address = $('#president_ceo_address').val();
            var president_ceo_id = $('#president_ceo_id').val();
            
                var shareholders = [];
                shareholders['name'] = president_ceo_name;
                shareholders['address'] = president_ceo_address;
                shareholders['stakeholder_id'] = president_ceo_id;
                shareholders['is_president_ceo'] = 1;
                shareholders['stakeholder_id'] = president_ceo_id;
                var shareholders_data = Object.assign({}, shareholders);
                shareholders_datas.push(shareholders_data);

            var treasurer_cfo_name = $('#treasurer_cfo_name').val();    
            var treasurer_cfo_address = $('#treasurer_cfo_address').val();
            var treasurer_cfo_id = $('#treasurer_cfo_id').val();
                var shareholders = [];
                shareholders['name'] = treasurer_cfo_name;
                shareholders['address'] = treasurer_cfo_address;
                shareholders['stakeholder_id'] = treasurer_cfo_id;
                shareholders['is_treasurer_cfo'] = 1;
                shareholders['stakeholder_id'] = treasurer_cfo_id;
                var shareholders_data = Object.assign({}, shareholders);
                shareholders_datas.push(shareholders_data);

            var secretary_name = $('#secretary_name').val();    
            var secretary_address = $('#secretary_address').val();
            var secretary_id = $('#secretary_id').val();

                var shareholders = [];
                shareholders['name'] = secretary_name;
                shareholders['address'] = secretary_address;
                shareholders['stakeholder_id'] = secretary_id;
                shareholders['is_secretary'] = 1;
                shareholders['stakeholder_id'] = secretary_id;
                var shareholders_data = Object.assign({}, shareholders);
                shareholders_datas.push(shareholders_data);

            var company_formation_id = $('#company_formation_id').val();
        
            // var api_url = "{{ Route('api.submit-director-officers-data') }}";
            
            var api_url = "https://occams.ai/app/public/api/submit-director-officers-data";
            var deleted_director_id = $('#deleted_director_id').val();

        var formData = {
            company_formation_id: company_formation_id,
            deleted_id:deleted_director_id,
            stakeholder_data: shareholders_datas
        };
        
        $.ajax({
            url: api_url,
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(shareResponse) {
                console.log(shareResponse);
   
                $(member_container).each(function(dnindex,delement) {
                    $(this).find('input[name^="director_id_"]').val(shareResponse.stakeholder_id[dnindex].stakeholder_id);
                });

                if(shareResponse.officer_data.president_ceo.stakeholder_id  !== undefined ){
                    $('#president_ceo_id').val(shareResponse.officer_data.president_ceo.stakeholder_id);
                }
                if(shareResponse.officer_data.treasurer_cfo.stakeholder_id !== undefined ){
                    $('#treasurer_cfo_id').val(shareResponse.officer_data.treasurer_cfo.stakeholder_id);
                }
                if(shareResponse.officer_data.secretary.stakeholder_id !== undefined  ){
                    $('#secretary_id').val(shareResponse.officer_data.secretary.stakeholder_id);    
                }

            },
            error: function(xhr) {
                var errors = xhr.responseJSON.message;
                if (errors) {
                    $('#error-message').html(errors).show();
                } else {
                    errors = "Opps! Something went wrong, Please try again.";
                    $('#error-message').html(errors).show();
                }
            }
        });
    }


    function UpdateCompanyManagerData(llc_managed_type) {
        var shareholders = [];
        var shareholders_datas = [];
        var company_formation_id = $('#company_formation_id').val();
        var api_url = "https://occams.ai/app/public/api/submit-company-member-manager";

        if (llc_managed_type === 'member_managed') {
            var member_container = '#member-container .member-profile-form';
            $(member_container).each(function() {
                shareholders['name'] = $(this).find('input[name^="member_name_"]').val();
                shareholders['address'] = $(this).find('input[name^="member_address_"]').val();
                shareholders['manager_member_id'] = $(this).find('input[name^="owner_id_"]').val();
                shareholders['is_manager'] = 0;
                shareholders['is_member'] = 1;
                shareholders['ownership_percentage'] = $(this).find('input[name^="shareholder_shares_"]').val();

                var shareholders_data = Object.assign({}, shareholders);
                shareholders_datas.push(shareholders_data);
            });
        } else if (llc_managed_type === 'manager_managed') {
            var manager_container = '#manager .manager-details__fields';
            $(manager_container).each(function() {
                shareholders['name'] = $(this).find('input[name^="manager_name_"]').val();
                shareholders['address'] = $(this).find('input[name^="manager_address_"]').val();
                shareholders['manager_member_id'] = $(this).find('input[name^="managers_id_"]').val();
                shareholders['is_manager'] = 1;
                shareholders['is_member'] = 0;
                shareholders['ownership_percentage'] = 0;

                if ($(this).find('input[name^="manager_owner_"]:checked').val() === 'yes') {
                    shareholders['is_member'] = 1;
                    shareholders['ownership_percentage'] = $(this).find('input[name^="shareholder_shares_"]').val();
                }

                var shareholders_data = Object.assign({}, shareholders);
                shareholders_datas.push(shareholders_data);
            });

            var member_container = '#member-container .member-profile-form';
            $(member_container).each(function() {
                shareholders['name'] = $(this).find('input[name^="member_name_"]').val();
                shareholders['address'] = $(this).find('input[name^="member_address_"]').val();
                shareholders['manager_member_id'] = $(this).find('input[name^="owner_id_"]').val();
                shareholders['is_manager'] = 0;
                shareholders['is_member'] = 1;
                shareholders['ownership_percentage'] = $(this).find('input[name^="shareholder_shares_"]').val();

                var shareholders_data = Object.assign({}, shareholders);
                shareholders_datas.push(shareholders_data);
            });
        }

        var formData = {
            company_formation_id: company_formation_id,
            manager_member_data: shareholders_datas
        };

        $.ajax({
            url: api_url,
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                if (llc_managed_type === 'manager_managed') {
                    var manager_container = '#manager .manager-details__fields';
                    $(manager_container).each(function(mindex, melement) {
                        $(this).find('input[name^="managers_id_"]').val(response.manager_id[mindex].manager_member_id);
                    });
                }
                var member_container = '#member-container .member-profile-form';
                $(member_container).each(function(mnindex, mnvalue) {
                    $(this).find('input[name^="owner_id_"]').val(response.member_id[mnindex].member_id);
                });
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.message;
                if (errors) {
                    $('#error-message').html(errors).show();
                } else {
                    errors = "Oops! Something went wrong, Please try again.";
                    $('#error-message').html(errors).show();
                }
            }
        });
    }

    function openPaymentTab(packageName, amount, packageID,package_type,subscription_price,currency_id,currency_code,currency_symbol) {
        $('.payment-div').removeClass('d-none');
        $('#messages').html('');

        var initial_amount = parseInt(amount);

        var paymentToken = '';
        var client_id = 0;
        let company_formation_id = $('#company_formation_id').val();
        var user_id =  $('#current_user_id').val();
        $(".coupon-header h4").text(packageName);

        $(".coupon-header p span").text(currency_symbol + parseFloat(subscription_price).toFixed(2));
        if (package_type != '') {
            $("#packagetypes").text(" /per " + package_type);
        } else {
            $("#packagetypes").text("");
        }
        $('#statefees').text(currency_symbol+$('#state-fee-id').val() + ' (State Filing Fee)');     

        var stripe = Stripe('<?= $stripe_publish_key; ?>');

        $.ajax({
            url: 'https://occams.ai/includes/generate-token.php',
            type: 'POST',
            data: {
                amount: amount,
                packageName: packageName
            },
            success: function(response) {
                console.log(response);
                var res = JSON.parse(response);
                if (res.status == true) {

                    document.getElementById("payment-popup").style.display = "flex";
                    // $("#payment-popup").modal('show');
                    paymentToken = res.token;
                   
                    const stripe = Stripe('<?= $stripe_publish_key; ?>', {
                        apiVersion: '2020-08-27',
                    });
                    console.log('stripe : ' +stripe);
                    const appearance = {
                        theme: 'stripe', // You can choose a theme here (stripe, flat, night)
                        variables: {
                            colorPrimary: '#0570de',
                            colorBackground: '#f6f9fc',
                            colorText: '#30313d',
                            spacingUnit: '4px',
                            borderRadius: '4px',
                            fontFamily: 'sans-serif',
                        },
                        rules: {
                            '.Input': {
                                backgroundColor: 'white',
                                borderColor: '#e1e3e6',
                            },
                            '.Label': {
                                fontWeight: 'bold',
                            },
                        },
                    };

                    const elements = stripe.elements({
                        appearance,
                        clientSecret: paymentToken
                    });

                    var style = {
                        base: {
                            fontSize: '40px',
                            color: '#32325d',
                            '::placeholder': {
                                color: '#000000',
                                fontSize: '40px',
                            }
                        },
                        invalid: {
                            color: '#fa755a'
                        }
                    };

                    var card = elements.create('card', {
                        hidePostalCode: true
                    }, {
                        style: style
                    });
                    card.mount('#card-element');

     console.log(card);

                    // Create and mount the Address Element
                    const addressElement = elements.create('address', {
                        mode: 'billing',
                        fields: {
                            line1: 'auto',
                            line2: 'auto',
                            city: 'auto',
                            state: 'auto',
                            country: 'auto',
                            postal_code: 'auto',
                        },
                        defaultValues: {
                            name: '<?php echo 'Test'; ?>',
                            address: {
                                line1: '<?php echo 'line1111'; ?>',
                                line2: '<?php echo 'line22'; ?>',
                                city: '<?php echo 'city1'; ?>',
                                state: '<?php echo 'AL'; ?>',
                                postal_code: '<?php echo '43322'; ?>',
                                country: 'US', // Assuming you know the country is always US
                            },
                        },
                    });
        console.log('addressElement' + addressElement);
                    // email: document.getElementById('email').value,
                    var billingDetails = {
                        name: $('#Field-nameInput').val(),
                        address: {
                            line1: $('#Field-addressLine1Input').val(),
                            line2: $('#Field-addressLine2Input').val(),
                            city: $('#Field-localityInput').val(),
                            state: $('#Field-administrativeAreaInput').val(),
                            postal_code: $('#Field-postalCodeInput').val(),
                            country: $('#Field-countryInput').val()
                        }
                    };

                    console.log(billingDetails);

                    addressElement.mount('#address-element');
                    const payButton = document.getElementById('pay-button');

                    $("#choose-plan-modal .modal-body .row").show();
                    $("#choose-plan-modal .modal-body .loading-view").hide();

                    const paymentForm = document.querySelector('#payment-form');
                    paymentForm.addEventListener('submit', async (e) => {
                        // Avoid a full page POST request.
                        e.preventDefault();

                        // Disable the form from submitting twice.
                        payButton.disabled = true;
                        payButton.textContent = 'Processing...';


                        // Step 1: Create a Payment Method
                        const {
                            paymentMethod,
                            error
                        } = await stripe.createPaymentMethod({
                            type: 'card',
                            card: card,
                            billing_details: billingDetails
                        });

                        console.log(paymentMethod);
                        if (error) {
                            if (error.type == "validation_error") {
                                payButton.disabled = false;
                                payButton.textContent = 'Pay';
                            } else {
                
                            }




                        } else if (paymentMethod && paymentMethod.id && package_type != '') {

                            // Step 2: Send payment method to backend
                            $.ajax({
                                url: 'https://occams.ai/includes/stripe_payment.php',
                                type: 'POST',
                                data: JSON.stringify({
                                    paymentMethodId: paymentMethod.id
                                }),
                                success: function(sresponse) {
                                    var res = JSON.parse(sresponse);
                                    var new_customer_id = res.customer_id;
                                    var paymentMethod_val = paymentMethod.id;
                                    var api_url = 'https://occams.ai/app/public/api/subscription';

                                    $.ajax({
                                        url: api_url,
                                        method: 'POST',
                                        data: JSON.stringify({
                                            "payment_method": paymentMethod_val,
                                            "customer_id": new_customer_id,
                                            "company_id": company_formation_id,
                                            "package_id": packageID,
                                            "package_type": package_type,
                                            "amount": amount,
                                            "subscription_price" :subscription_price,
                                            "packageName" :packageName,
                                            "currency_id": currency_id,
                                            "currency_code" : currency_code
                                        }),
                                        contentType: 'application/json',
                                        success: function(response) {
                                            console.log(response);
                                            var api_url = 'https://occams.ai/app/public/api/save-payment';
                                            // var api_url = "{{ Route('api.save-payment') }}";
                                            $.ajax({
                                                url: api_url,
                                                type: 'POST',
                                                data: {
                                                    error: error,
                                                    paymentIntent: paymentMethod,
                                                    company_formation_id: company_formation_id,
                                                    packageID: packageID,
                                                    amount: amount,
                                                    client_id: user_id,
                                                    currency_id: currency_id,
                                                    subscription_id:response.subscription.id,
                                                    completed_step:6
                                                },
                                                success: function(response) {
                                                    console.log(response);
                                                    var res_save = response;
                                                    // var res_save = JSON.parse(response);
                                                    if (res_save.status == true) {
                                                        $('#payment_next_btn').attr("style", "filter:unset;pointer-events:unset;");
                                                        swal.fire({
                                                            title: "Payment Successful!🎉",
                                                            type: "success",
                                                            button: "Ok",
                                                        }).then((value) => {
                                                            if (value) {
                                                                location.reload();
                                                                // window.location.href = "/app/public/account/company-formation/view/"+company_formation_id;
                                                            }
                                                        });

                                                    } else {
                                                        $('#messages').show().html('<div class="alert alert-danger mt-3"  role="alert">' + res_save.massage + '</div>');
                                                    }
                                                }
                                            });
                                        }
                                    });
                                }
                            });

                        }else{
                            // var api_url = "{{ Route('api.save-payment') }}";
                            var api_url = 'https://occams.ai/app/public/api/save-payment';
                            $.ajax({
                                url: api_url,
                                type: 'POST',
                                data: {
                                    error: error,
                                    paymentIntent: paymentMethod,
                                    company_formation_id: company_formation_id,
                                    packageID: packageID,
                                    amount: amount,
                                    client_id: user_id,
                                    currency_id: currency_id,
                                    completed_step:6,
                                },
                                success: function(response) {
                                    console.log(response);
                                    var res_save = response;
                                    if (res_save.status == true) {
                                        $('#payment_next_btn').attr("style", "filter:unset;pointer-events:unset;");
                                        swal.fire({
                                            title: "Payment Successful!🎉",
                                            type: "success",
                                            button: "Ok",
                                        }).then((value) => {
                                            if (value) {
                                               
                                                location.reload();
                                                // window.location.href = "/app/public/account/company-formation/view/"+company_formation_id;
                                            }
                                        });

                                    } else {
                                        $('#messages').show().html('<div class="alert alert-danger mt-3"  role="alert">' + res_save.massage + '</div>');
                                    }
                                }
                            });
                        }

                    });

                } else {
                    $('#messages').html('<div class="alert alert-danger mt-3"  role="alert">' + res.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#messages').html('<div class="alert alert-danger mt-3"  role="alert">Something went wrong.</div>');
            }
        });
    }

    // function for payment

    function payment() {
        var packageName = "Company Formation Signup";
        var companyID = $('#company_formation_id').val();
        var packageID = 1;
        var amount = 100;
        var initial_amount = 100;

        let queryString = "?payment_amount=" + amount + "&package_id=" + packageID + "&company_id=" + companyID;
        let url = "{{ route('stripe_payment') }}" + queryString;

        $.ajax({
            type: "POST",
            url: url,
            data: {
                amount: amount,
                packageName: packageName,
                packageID: packageID,
            },
            success: function(res) {
                if (res.status == 200) {} else {
                  
                }
            },
            error: function(xhr, status, error) {
               
            }
        })
    }


    // });

    function getCompanyFormationData() {
        var api_url = "https://occams.ai/app/public/api/company-data";

        var company_formation_id = $('#company_formation_id').val();
        const formData = {
            company_formation_id: company_formation_id,
        };
        $.ajax({
            url: api_url,
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                // console.log(response);
                if (response.status === 'success') {
                    var rv_client_id = response.company_formation_data.client_id;
                    var rv_state_id = response.company_formation_data.state_id;
                    var rv_company_type = response.company_formation_data.company_type;
                    var rv_state_fee = response.company_formation_data.state_fee;
                    var rv_business_name = response.company_formation_data.business_name;
                    var rv_designator = response.company_formation_data.designator;
                    var rv_purpose_of_company = response.company_formation_data.purpose_of_company;
                    var rv_member_type = response.company_formation_data.member_type;
                    var rv_llc_managed_type = response.company_formation_data.llc_managed_type;
                    var rv_number_of_shares_authorized = response.company_formation_data.number_of_shares_authorized;
                    var rv_shares_par_value = response.company_formation_data.shares_par_value;
                    var rv_total_ownership = response.company_formation_data.total_ownership;
                    var rv_registered_agent_type = response.company_formation_data.registered_agent_type;
                    var rv_registered_agent_name = response.company_formation_data.registered_agent_name;
                    var rv_registered_agent_address = response.company_formation_data.registered_agent_address;
                    var rv_registered_email_address = response.company_formation_data.registered_email_address;
                    var rv_virtual_mailbox_type = response.company_formation_data.virtual_mailbox_type;
                    var rv_virtual_mailbox_address = response.company_formation_data.virtual_mailbox_address;

                    var owner_html = '<div class="table-title">Entity Stakeholder</div><table id="review-table"><thead><tr><th>Name</th><th>Address</th><th>Ownership% / No. of Shares</th><th>Title</th></tr></thead><tbody>';
                    
                    var owner_table_data = getOwnerTableHtml(response.manager_member_data,response.shareholder_data);  
                     owner_html += owner_table_data;   
                     owner_html +='</tboady></table>';

                    // company_officers_data

                    // --- set value in review tab -------
                    $("#rv-state").val(rv_state_id);
                    $("#rv-company-type").val(rv_company_type);
                    $("#rv-business_name").val(rv_business_name);
                    $("#rv-designator-select").val(rv_designator);
                    $("#rv-purpose").val(rv_purpose_of_company);
                    $('#rv-state-fee').html('State Filing Fee : <b>$' + rv_state_fee + '</b>');

                    if (rv_registered_agent_type == 'provided') {
                        $("#rv-agent-own").prop('checked', false);
                        $("#rv-agent-service").prop('checked', true);
                        $('#rv-agent-conditional-field').css('display', 'none');
                    }
                    if (rv_registered_agent_type == 'own') {
                        $("#rv-agent-own").prop('checked', true);
                        $("#rv-agent-service").prop('checked', false);
                        $('#rv-agent-conditional-field').css('display', 'flex');
                        $("#rv-registered_agent_name").val(rv_registered_agent_name);
                        $("#rv-registered_agent_address").val(rv_registered_agent_address);
                        $("#rv-registered_email_address").val(rv_registered_email_address);
                    }
                    if (rv_virtual_mailbox_type == 'provided') {
                        $("#rv-mailbox-own").prop('checked', false);
                        $("#rv-mailbox-service").prop('checked', true);
                        $('#rv-mailbox-conditional-field').hide();
                    }
                    if (rv_virtual_mailbox_type == 'own') {
                        $('#rv-mailbox-conditional-field').show();
                        $("#rv-mailbox-service").prop('checked', false);
                        $("#rv-mailbox-own").prop('checked', true);
                        $("#rv-virtual_mailbox_address").val(rv_virtual_mailbox_address);
                    }

                    // member value set ----
                    if (rv_company_type == 'llc') {
                        $('#rv-s-c-corp-shares-structure').hide();
                        $('#rv-llc-shares-structure').show();
                        if (rv_company_type == 'llc' && rv_llc_managed_type == "manager_managed") {
                            $('#rv-member-managed').prop('checked',false);
                            $('#rv-manager-managed').prop('checked',true);
                        } else {
                            $('#rv-member-managed').prop('checked',true);
                            $('#rv-manager-managed').prop('checked',false);
                        }
                    } else {
                        $('#rv-s-c-corp-shares-structure').show();
                        $('#rv-llc-shares-structure').hide();
                        $("#rv-shares-authorized").val(rv_number_of_shares_authorized);
                        $("#rv-par-value").val(rv_shares_par_value);
                        // $("#rv-total-ownership-value").val(rv_total_ownership);

                    }

                    if (owner_html != '') {
                        $('#rv-member-shareholder-table').html(owner_html);
                    }

                } else {
                    console.log('not success.');
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.message;
                if (errors) {
                    $('#error-message').html(errors).show();
                } else {
                    errors = "Opps! Something went wrong, Please try again.";
                    $('#error-message').html(errors).show();
                }
            }
        });
    }

    function getOwnerDetailHtml(element, i) {
        var rv_owner_type = element.owner_type;
        var rv_name = element.name;
        var rv_address = element.address;
        var rv_shares_owned = element.shares_owned;
        var rv_ownership_percentage = element.ownership_percentage;
        var rv_owner_id = element.id;
        var html = '';
        if (rv_owner_type != 'shareholder') {
            html = `<div class="shareholder_member">
            <div class="member-title"><span>Member ${i}</span></div>
            <div class="row member-details">
                        <div class="form-group col-sm-4">
                    <label class="f-14 text-dark-grey mb-12" for="member-name">Member Name</label>
                    <input type="hidden" value="${rv_owner_id}">
                    <input type="text" class="form-control height-35 f-14 shareholder_input" id="rv-member-name"  value="${rv_name}" readonly>
                </div>
                <div class="form-group col-sm-4">
                    <label class="f-14 text-dark-grey mb-12" for="member-address">Member Address</label>
                    <input type="text" class="form-control height-35 f-14 shareholder_input rv-address" id="rv-member-address"  value="${rv_address}" readonly>
                </div>
                <div class="form-group col-sm-4">
                    <label class="f-14 text-dark-grey mb-12" for="ownership-percentage">Ownership Percentage</label>
                    <input type="number" class="form-control height-35 f-14 shareholder_input" id="rv-ownership-percentage"  value="${rv_ownership_percentage}" readonly>
                </div></div></div>`;
        } else {
            html = `<div class="shareholder_member">
                            <div class="member-title"><span>Shareholder ${i}</span></div>
                            <div class="row member-details">
                            <div class="form-group col-sm-4">
                            <label class="f-14 text-dark-grey mb-12">Name:</label>
                             <input type="hidden" value="${rv_owner_id}">   
                            <input type="text" class="form-control height-35 f-14 shareholder_input" name="shareholder_name_${i}"  value="${rv_name}" readonly>
                            <span class="error-message"></span>
                            </div>
                            <div class="form-group col-sm-4">
                            <label class="f-14 text-dark-grey mb-12">Address:</label>
                            <input type="text" class="form-control height-35 f-14 shareholder_input rv-address" name="shareholder_address_${i}"  value="${rv_address}" readonly>
                            <span class="error-message"></span>
                            </div>
                            <div class="form-group col-sm-4">
                            <label class="f-14 text-dark-grey mb-12">Shares Owned:</label>
                            <input type="number" class="form-control height-35 f-14" class="shares shareholder_input shares_num" name="shareholder_shares_${i}" min="1" value="${rv_shares_owned}" readonly>
                            </div>
                        </div>
                        </div>`;
        }

        return html;
    }



    function getOwnerTableHtml(manager_member_data,shareholder_data){
        
             var table_div = '';
             var rv_member_manager_array = [];
             
             $(manager_member_data).each(function(index, element) {
                    var title = '';
                    var ownership_percentage = '';
                    if(element.is_manager==1 && element.is_member==1){
                         title = "Member & Manager";
                         ownership_percentage = element.ownership_percentage;
                    }else if(element.is_manager==1){
                         title = "Manager";
                         ownership_percentage ='';
                    }else if(element.is_member==1){
                         title = "Member";
                         ownership_percentage =element.ownership_percentage;
                    }
                    if(ownership_percentage==null){
                        ownership_percentage = '';
                    }
                    table_div +='<tr><td>'+element.name+'</td><td>'+element.address+'</td><td>'+ownership_percentage+'</td><td>'+title+'</td></tr>';
            });

                $(shareholder_data).each(function(sindex, selement) {
                    var title = '';
                    var no_of_shares = '';
                    
                    if(selement.is_shareholder==1 && selement.is_director==1){
                         title = "Shareholder & Director";
                         no_of_shares = selement.no_of_shares;
                    }else if(selement.is_shareholder==1 && selement.is_president_ceo==1){
                         title = "Shareholder & President/CEO";
                         no_of_shares = selement.no_of_shares;
                    }else if(selement.is_shareholder==1 && selement.is_secretary==1){
                         title = "Shareholder & Secretary";
                         no_of_shares = selement.no_of_shares;
                    }else if(selement.is_shareholder==1 && selement.is_treasurer_cfo==1){
                         title = "Shareholder & Treasurer/CFO";
                         no_of_shares = selement.no_of_shares;
                    }else if(selement.is_shareholder==1){
                         title = "Shareholder";
                         no_of_shares = selement.no_of_shares;
                    }else if(selement.is_director==1){
                         title = "Director";
                    }else if(selement.is_president_ceo==1){
                         title = "President/CEO";
                    }else if(selement.is_secretary==1){
                         title = "Secretary";
                    }else if(selement.is_treasurer_cfo==1){
                         title = "Treasurer/CFO";
                    }
                    if(no_of_shares==null){
                        no_of_shares = '';
                    }
                    table_div +='<tr><td>'+selement.name+'</td><td>'+selement.address+'</td><td>'+no_of_shares+'</td><td>'+title+'</td></tr>';
                });   
            
            return table_div;
    }
</script>


<script type="text/javascript">
    function addFieldsRow(containerId, fieldType, childClass) {
        const container = document.getElementById(containerId);
        let count = container.querySelectorAll(`.${childClass}`).length + 1;

        let html = '';

        if (fieldType === 'manager') {
            html = `
                <div class="flex flex-wrap justify-between gap-4 items-center mt-4 ${childClass}">
                    <div class="w-[15%]">
                        <div class="form__member-row">
                            <div class="form__member-counter-container">
                                <p class="header__profile-name">Manager ${count}</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-[20%]">
                        <div class="form__field-2">
                            <label class="form__label">Manager name</label>
                            <input type="hidden" name="managers_id_${count}" id="managers_id_${count}" value="">
                            <div class="form__input"><input name="manager_name_${count}" type="text" autocomplete="off"></div>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="w-[20%]">
                        <div class="form__field-2">
                            <label class="form__label">Manager address</label>
                            <div class="form__input"><input name="manager_address_${count}" class="rv-address" type="text" autocomplete="off"></div>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="w-[30%] manager-member__form-section">
                        <div class="flex flex-col">
                            <label class="mb-1">Is this manager also a member (Owner)?</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center space-x-1">
                                    <input type="radio" name="manager_owner_${count}" no_id="${count}"  value="yes" class="form-radio text-orange-500 member_manager" >
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center space-x-1">
                                    <input type="radio" name="manager_owner_${count}" no_id="${count}"  value="no" class="form-radio text-gray-500 member_manager" checked>
                                    <span>No</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="w-[5%] flex justify-center items-center">
                        <img src="https://occams.ai/assets/images/images/delete-red.svg" alt="delete" title="Remove" class="cursor-pointer" onclick="removeMember(this)">
                    </div>
                </div>`;
            document.getElementById('manager-count').textContent = `(${count})`;
        }

        else if (fieldType === 'member') {
            html = `
                <div class="flex flex-wrap justify-between gap-4 items-center mt-4 ${childClass}">
                    <div class="w-[15%]">
                        <div class="form__member-row bg-[#FFE7DA73]">
                            <div class="form__member-counter-container">
                                <p class="header__profile-name">Member ${count}</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-[25%]">
                        <div class="form__field-2">
                            <label class="form__label">Member name</label>
                            <input type="hidden" name="owner_id_${count}" id="owner_id_${count}" value="">
                            <div class="form__input"><input name="member_name_${count}" type="text" autocomplete="off"></div>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="w-[35%]">
                        <div class="form__field-2">
                            <label class="form__label">Member address</label>
                            <div class="form__input "><input name="member_address_${count}" class="rv-address" type="text" autocomplete="off"></div>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="w-[12%]">
                        <div class="form__field-2">
                            <label class="form__label">Ownership %</label>
                            <div class="form__input"><input class="ownership_percentage_value" name="shareholder_shares_${count}" type="number" placeholder="%" min="0" autocomplete="off"></div>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="w-[5%] flex justify-center items-center">
                        <img src="https://occams.ai/assets/images/images/delete-red.svg" alt="delete" title="Remove" class="cursor-pointer" onclick="removeMember(this)">
                    </div>
                </div>`;
            document.getElementById('member-count').textContent = `(${count})`;
        }
        else if (fieldType === 'shareholder') { 
            html = `
            <div class="flex flex-wrap justify-between gap-4 items-center mt-4 ${childClass}">
                <div class="w-[15%]">
                <div class="form__member-row bg-[#F4F4F4]">
                    <div class="form__member-counter-container">
                    <p class="header__profile-name">Shareholder ${count}</p>
                    </div>
                </div>
                </div>
                <div class="w-[18%]">
                <div class="form__field-2">
                    <label class="form__label">Shareholder name</label>
                    <input type="hidden" name="owner_id_${count}" id="owner_id_${count}" value="">
                    <div class="form__input"><input name="shareholder_name_${count}" type="text" autocomplete="off"></div>
                    <span class="error-message"></span>
                </div>
                </div>
                <div class="w-[18%]">
                <div class="form__field-2">
                    <label class="form__label">Shareholder address</label>
                    <div class="form__input"><input name="shareholder_address_${count}" class="rv-address" type="text" autocomplete="off"></div>
                    <span class="error-message"></span>
                </div>
                </div>
                <div class="w-[20%]">
                <div class="form__field-2">
                    <label class="form__label">Number of shares owned</label>
                    <div class="form__input"><input name="shareholder_shares_${count}" class="shares_num" type="number" min="0" autocomplete="off"></div>
                    <span class="error-message"></span>
                </div>
                </div>
                <div class="w-[16%]">
                <div class="form__field-2">
                    <label class="form__label">Is Director/Officer?</label>
                    <div class="form__input">
                    <select class="w-full border border-black rounded" name="shareholder_director_${count}" id="shareholder_director_${count}">
                            <option value="NA">NA</option>
                            <option value="Director">Director</option>
                            <option value="President/CEO">President/CEO</option>
                            <option value="Secretary">Secretary</option>
                            <option value="TReasurer/CFO">TReasurer/CFO</option>
                    </select>
                    </div>
                    <span class="error-message"></span>
                </div>
                </div>
                <div class="w-[5%] flex justify-center items-center">
                <img src="https://occams.ai/assets/images/images/delete-red.svg" alt="delete" title="Remove" class="cursor-pointer" onclick="removeMember(this)">
                </div>
            </div>`;
            document.getElementById('shareholder-count').textContent = `(${count})`;
        }

        else if (fieldType === 'director') {
            html = `
                <div class="flex flex-wrap justify-between gap-4 items-center mt-4 ${childClass}">
                    <div class="w-[15%]">
                        <div class="form__member-row">
                            <div class="form__member-counter-container">
                                <p class="header__profile-name">Director ${count}</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-[30%]">
                        <div class="form__field-2">
                            <label class="form__label">Director name</label>
                            <input type="hidden" name="director_id_${count}" id="director_id_${count}" value="">
                            <div class="form__input"><input name="director_name_${count}" type="text" autocomplete="off"></div>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="w-[45%]">
                        <div class="form__field-2">
                            <label class="form__label">Director address</label>
                            <div class="form__input">
                                <input name="director_address_${count}" type="text" autocomplete="off">
                            </div>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="w-[5%] flex justify-center items-center">
                        <img src="https://occams.ai/assets/images/images/delete-red.svg" alt="delete" title="Remove" class="cursor-pointer" onclick="removeMember(this, 'director')">
                    </div>
                </div>`;
                  // count 
        document.getElementById('director-count').textContent = `(${count})`;
        }
      

        container.insertAdjacentHTML('beforeend', html);
    }


    function removeMember(button) {
        const row = button.closest('div.flex.flex-wrap');
        if (row) row.remove();

        // Determine if it's a member or manager being removed
        const isMember = row.classList.contains('member-profile-form');
        const isManager = row.classList.contains('manager-details__fields');
        const isDirector = row.classList.contains('director-profile-form');
        const isShareholder = row.classList.contains('shareholder-profile-form');
    
        if (isMember) {
            const container = document.getElementById('member-container');
            const count = container.querySelectorAll('.member-profile-form').length;
            document.getElementById('member-count').textContent = `(${count})`;
        } else if (isManager) {
            const container = document.getElementById('manager');
            const count = container.querySelectorAll('.manager-details__fields').length;
            document.getElementById('manager-count').textContent = `(${count})`;
        }else if (isShareholder) {
            const container = document.getElementById('shareholder-container');
            const count = container.querySelectorAll('.shareholder-profile-form').length;
            document.getElementById('shareholder-count').textContent = `(${count})`;
        }else if (isDirector) {
            const container = document.getElementById('director-container');
            const count = container.querySelectorAll('.member-profile-form').length;
            document.getElementById('director-count').textContent = `(${count})`;
        }
    }

    $(document).on("change",'.member_manager', function() {
             var no_id = $(this).attr("no_id");
             var checkboxValue = $(this).val();  
             var isChecked = $(this).is(":checked");

            if(checkboxValue=="yes" && isChecked){
                $(this).closest('.manager-member__form-section').before(`<div class="form__field-2 manager-ownership"><label class="form__label">Ownership %</label><div class="form__input"><input class="ownership_percentage_value" placeholder="%" name="shareholder_shares_`+no_id+`" type="number" min="0"></div><span class="error-message"></span></div>`);
                $("#member_manager_"+no_id+"_no").prop('checked',false);
                // w-[25%] w-[30%]
                $(this).closest('.manager-member__form-section').removeClass("w-[30%]");
                $(this).closest('.manager-member__form-section').addClass("w-[20%]");
            }else{
                $("#member_manager_"+no_id+"_yes").prop('checked',false);
                $(this).closest('.manager-details__fields').find('.manager-ownership').remove();
                $(this).closest('.manager-member__form-section').removeClass("w-[20%]");
                $(this).closest('.manager-member__form-section').addClass("w-[30%]");
            } 
    });

    $(document).on('input', '.ownership_percentage_value', function() {
        var num = 0;
        document.querySelectorAll('.ownership_percentage_value').forEach(function(input) {
            if (input.value != '') {
                num += parseInt(input.value);
            }
        });
        if (num > 100) {
            var excess = num - 100;
            var currentValue = parseInt($(this).val());
            $(this).val(currentValue - excess);
            $(this).addClass('is-invalid');
            $(this).closest('.form__input').next('.error-message').html('Total ownership can not exceed 100%');
        } else {
            $(this).removeClass('is-invalid');
            $(this).closest('.form__input').next('.error-message').html('');
        }
    });

    
    $(document).on('input', '.shares_num', function() {
        var num = 0;
        var shares_authorized = parseInt(jQuery('#shares-authorized').val());

        if (shares_authorized != '') {
            document.querySelectorAll('.shares_num').forEach(function(input) {
                if (input.value != '') {
                    num += parseInt(input.value);
                }
            });
            if (num > shares_authorized) {
                var excess = num - shares_authorized;
                var currentValue = parseInt($(this).val());
                $(this).val(currentValue - excess);
                $(this).addClass('is-invalid');
                $(this).closest('.form__input').next('.error-message').html('Total shares should not exceed Authorized shares');
            } else {
                $(this).removeClass('is-invalid');
                $(this).closest('.form__input').next('.error-message').html('');
            }
        }
    });
    $(document).on('change', '#shares-authorized', function() {
        var num = 0;
        var shares_authorized = parseInt(jQuery(this).val());
        document.querySelectorAll('.shares_num').forEach(function(input) {
            if (input.value != '') {
                num += parseInt(input.value);
            }
        });
        if (num > shares_authorized) {
            $(this).val(num);
            $(this).addClass('is-invalid');
            $(this).next('.error-message').html('Authorized shares should not less than shareholder owned shares');
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.error-message').html('');
        }
    });

</script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmcb4GdZedga6u7gUcCc_fB1KP1kyvGEQ&libraries=places"></script>
<script>
    function initdynamicAutocomplete() {

        document.querySelectorAll('.rv-address').forEach(function(addressInput) {
            // console.log(addressInput);
            // document.querySelectorAll('[id^="bstreet_address"]').forEach((addressInput) => {
            const inputId = addressInput.id;
            // const index = inputId.match(/\d+/)[0]; 
            const options = {
                types: ['address'],
                componentRestrictions: {
                    country: 'us'
                }
            };

            const autocomplete = new google.maps.places.Autocomplete(addressInput, options);

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();

                // Extracting address components
                const addressComponents = place.address_components;
                const addressDetails = {
                    street: '',
                    city: '',
                    state: '',
                    zipCode: '',
                    country: ''
                };

                addressComponents.forEach(component => {
                    const componentType = component.types[0];
                    switch (componentType) {
                        case 'street_number':
                            addressDetails.street = component.long_name + ' ' + addressDetails.street;
                            break;
                        case 'route':
                            addressDetails.street += component.long_name;
                            break;
                        case 'locality':
                            addressDetails.city = component.long_name;
                            break;
                        case 'administrative_area_level_1':
                            addressDetails.state = component.long_name;
                            break;
                        case 'postal_code':
                            addressDetails.zipCode = component.long_name;
                            break;
                        case 'country':
                            addressDetails.country = component.long_name;
                            break;
                    }
                    // console.log(addressComponents);
                });
            });
        });
    }
    google.maps.event.addDomListener(window, 'load', initdynamicAutocomplete());

    // call initdynamicautocomplete function on rv-address -input element
    $(document).on('input', '.rv-address', function() {
        initdynamicAutocomplete();
    });

      // on change director dropdown remove selected option
      $(document).ready(function () {
        $(document).on('change','.form__dropdown--ownership-type', function () {
            var thisv = this;
            const selectedValue = $(thisv).val();
            const currentSelect = $(thisv);
            var shareholder_name = $(thisv).attr('name');
                $(thisv).next(".error-message").text('');
                $("#shareholder-container .member-profile-form").each(function () {
                        let directorSelect = $(this).find('select[name^="shareholder_director_"]');
                        var role_select_name = $(this).find('select[name^="shareholder_director_"]').attr('name');
                            if(shareholder_name != role_select_name && directorSelect.val()!='Director'){
                                if(directorSelect.val() === selectedValue) {
                                    $(thisv).val('NA');
                                    $(thisv).next(".error-message").text(selectedValue+' Already selected.');
                                }
                            }
                });
        });
    });

    $('input[name="registered-agent"]').on('change', function() {
        if ($(this).val() === 'own') {
            $('#registered_agent_name, #registered_agent_address, #registered_email_address').on('input', function() {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                    $(this).next('.error-message').html('This field is required');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.error-message').html('');
                }
            });
            $('#agent-info').removeClass('hidden');
        } else {
            $('#agent-info').addClass('hidden');
            $('#registered_agent_name, #registered_agent_address, #registered_email_address').removeClass('is-invalid');
            $('#registered_agent_name, #registered_agent_address, #registered_email_address').next('.error-message').html('');
        }
    });

    
    $('input[name="mailbox"]').change(function() {
        let mailboxType = $('input[name="mailbox"]:checked').val();
        if (mailboxType == 'own') {
            $('#virtual_mailbox_address').on('input', function() {
                var address = $(this).val();
                if (address.trim() === '') {
                    $('#virtual_mailbox_address').addClass('is-invalid');
                    $('#virtual_mailbox_address').next('.error-message').html('This field is required');
                } else {
                    $('#virtual_mailbox_address').removeClass('is-invalid');
                    $('#virtual_mailbox_address').next('.error-message').html('');
                }
            });
            $('#mailbox-info').removeClass('hidden');
        } else {
            $('#mailbox-info').addClass('hidden');
            $('#virtual_mailbox_address').removeClass('is-invalid');
            $('#virtual_mailbox_address').next('.error-message').html('');
        }
    });

    $(document).on('click', '.package-btn', function() {
        $('.payment-div').addClass('d-none');
        var package_id = $(this).attr("data-package_id");
        var package_amount = parseFloat($(this).attr("data-amount")) || 0;
        var package_name = $(this).attr("data-package_name");
        var state_fee_val = parseFloat($('#state-fee-id').val()) || 0;
        var package_type = $(this).attr("data-package_type") || '';
        var currency_id = $(this).attr("data-currency_id") || '';
        var currency_code = $(this).attr("data-currency_code") || '';
        var currency_symbol = $(this).attr("data-currency_symbol") || '';
 
        var total_amount = package_amount + state_fee_val;
        var subscription_price = package_amount;
        openPaymentTab(package_name, total_amount, package_id,package_type,subscription_price,currency_id,currency_code,currency_symbol);
    });
</script>


<?php
include('footer.php');
?>