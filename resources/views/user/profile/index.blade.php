@extends('layouts.user.master')
@section('title')
    {{ __('profile.Profile') }}
@endsection
@section('page-css')
@endsection
@section('header_title')
    {{ __('profile.Profile') }}
@endsection
@section('content')
@php($user = \Illuminate\Support\Facades\Auth::user())
    <section id="page-account-settings">
        <div class="row">
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column nav-left">
                    <li class="nav-item">
                        <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#account-general" aria-expanded="true">
                            <i data-feather="user" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">{{ __('profile.General') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-password" aria-expanded="false">
                            <i data-feather="lock" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">{{ __('profile.Change Password') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-security" data-toggle="pill" href="#account-security" aria-expanded="false">
                            <i data-feather="shield" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">{{ __('profile.Security') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-sessions" data-toggle="pill" href="#account-sessions" aria-expanded="false">
                            <i data-feather="link" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">{{ __('profile.Sessions') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-activity" data-toggle="pill" href="#account-activity" aria-expanded="false">
                            <i data-feather="list" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">{{ __('profile.Activity Log') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="col-12 mt-75">
                        <div class="alert alert-warning mb-50" role="alert">
                            <h4 class="alert-heading">{{__('profile.Notice')}}</h4>
                            <div class="alert-body">
                                <span>{{__('profile.You do not have any external wallet. Please enter an external wallet to purchase and get your tokens.')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="account-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                <form class="validate-form" id="updateForm" action="{{route('user.profile.update')}}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="media">
                                        <a href="javascript:void(0);" class="mr-25">
                                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" id="profile_photo_img" class="rounded mr-50" height="80" width="80" />
                                        </a>
                                        <div class="media-body mt-75 ml-1">
                                            <label for="profile_photo" class="btn btn-sm btn-primary mb-75 mr-75">{{__('Upload')}}</label>
                                            <input type="file" id="profile_photo" name="profile_photo" hidden />
                                            <label id="pp-reset" class="btn btn-sm btn-outline-secondary mb-75">{{__('Reset')}}</label>
                                            <p>{{__('profile.Allowed JPG, JPEG or PNG. Max size of 1MB')}}</p>
                                            <div class="invalid-feedback" id="error_profile_photo" style="display:block;">{{ $errors->first('profile_photo') }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="name">{{__('profile.Name')}}</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="{{__('profile.Name')}}" value="{{$user->name}}" required/>
                                                <div class="invalid-feedback" id="error_name" style="display:block;">{{ $errors->first('name') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="telegram">{{__('profile.Telegram Username')}}</label>
                                                <input type="text" class="form-control" id="telegram" name="telegram" placeholder="{{__('profile.Telegram Username')}}" value="{{$user->telegram}}" />
                                                <div class="invalid-feedback" id="error_telegram" style="display:block;">{{ $errors->first('telegram') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label for="mobile">{{__('profile.Mobile')}}</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="country-for-mobile">+</span>
                                                </div>
                                                <input type="number" class="form-control" id="mobile" name="mobile" placeholder="{{__('profile.Mobile')}}" value="{{$user->mobile}}" />
                                            </div>
                                            <div class="invalid-feedback" id="error_mobile" style="display:block;">{{ $errors->first('mobile') }}</div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group country-selector">
                                                <label for="country">{{__('profile.Country')}}</label>
                                                <select id="country" name="country" class="select2 form-control">
                                                    <option value="">{{__('Select your country')}}</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Åland Islands">Åland Islands</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="American Samoa">American Samoa</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Anguilla">Anguilla</option>
                                                    <option value="Antarctica">Antarctica</option>
                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Aruba">Aruba</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bermuda">Bermuda</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia">Bolivia</option>
                                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Bouvet Island">Bouvet Island</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Cape Verde">Cape Verde</option>
                                                    <option value="Cayman Islands">Cayman Islands</option>
                                                    <option value="Central African Republic">Central African Republic</option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Christmas Island">Christmas Island</option>
                                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Congo">Congo</option>
                                                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                                    <option value="Cook Islands">Cook Islands</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                                                    <option value="Croatia">Croatia</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czech Republic">Czech Republic</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El Salvador">El Salvador</option>
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                                    <option value="Faroe Islands">Faroe Islands</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="French Guiana">French Guiana</option>
                                                    <option value="French Polynesia">French Polynesia</option>
                                                    <option value="French Southern Territories">French Southern Territories</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambia">Gambia</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Gibraltar">Gibraltar</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Greenland">Greenland</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guadeloupe">Guadeloupe</option>
                                                    <option value="Guam">Guam</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guernsey">Guernsey</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guinea-bissau">Guinea-bissau</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hong Kong">Hong Kong</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Isle of Man">Isle of Man</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jersey">Jersey</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kiribati">Kiribati</option>
                                                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                                    <option value="Korea, Republic of">Korea, Republic of</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon">Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Macao">Macao</option>
                                                    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                    <option value="Martinique">Martinique</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mayotte">Mayotte</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montenegro">Montenegro</option>
                                                    <option value="Montserrat">Montserrat</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Namibia">Namibia</option>
                                                    <option value="Nauru">Nauru</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                    <option value="New Caledonia">New Caledonia</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="Niue">Niue</option>
                                                    <option value="Norfolk Island">Norfolk Island</option>
                                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau">Palau</option>
                                                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Pitcairn">Pitcairn</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Puerto Rico">Puerto Rico</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Reunion">Reunion</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russian Federation">Russian Federation</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="Saint Helena">Saint Helena</option>
                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                    <option value="Saint Lucia">Saint Lucia</option>
                                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="San Marino">San Marino</option>
                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Serbia">Serbia</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra Leone">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Slovakia">Slovakia</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                                    <option value="Spain">Spain</option>
                                                    <option value="Sri Lanka">Sri Lanka</option>
                                                    <option value="Sudan">Sudan</option>
                                                    <option value="Suriname">Suriname</option>
                                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                                    <option value="Swaziland">Swaziland</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                                    <option value="Tajikistan">Tajikistan</option>
                                                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Timor-leste">Timor-leste</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tokelau">Tokelau</option>
                                                    <option value="Tonga">Tonga</option>
                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                    <option value="Tunisia">Tunisia</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                    <option value="Tuvalu">Tuvalu</option>
                                                    <option value="Uganda">Uganda</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States">United States</option>
                                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                    <option value="Uruguay">Uruguay</option>
                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                    <option value="Vanuatu">Vanuatu</option>
                                                    <option value="Venezuela">Venezuela</option>
                                                    <option value="Viet Nam">Viet Nam</option>
                                                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                                                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                                    <option value="Western Sahara">Western Sahara</option>
                                                    <option value="Yemen">Yemen</option>
                                                    <option value="Zambia">Zambia</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                </select>
                                                <div class="invalid-feedback" id="error_country" style="display:block;">{{ $errors->first('country') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="address">{{__('profile.Address')}}</label>
                                                <input type="text" class="form-control" id="address" name="address" placeholder="{{__('profile.Address')}}" value="{{$user->address}}" />
                                                <div class="invalid-feedback" id="error_address" style="display:block;">{{ $errors->first('address') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="city">{{__('profile.City')}}</label>
                                                <input type="text" class="form-control" id="city" name="city" placeholder="{{__('profile.City')}}" value="{{$user->city}}" />
                                                <div class="invalid-feedback" id="error_city" style="display:block;">{{ $errors->first('city') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" id="updateButton" class="btn btn-primary mt-2 mr-1">{{__('Save')}}</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-2">{{__('Reset')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="account-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                <form id="updatePasswordForm" class="needs-validation">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="current_password">{{__('profile.Old Password')}}</label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="{{__('profile.Old Password')}}" required/>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer">
                                                            <i data-feather="eye"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback" id="error_current_password"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="password">{{__('profile.New Password')}}</label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" id="password" name="password" class="form-control" placeholder="{{__('profile.New Password')}}" required/>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer">
                                                            <i data-feather="eye"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback" id="error_password"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">{{__('profile.Retype New Password')}}</label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="{{__('profile.New Password')}}" required/>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback" id="error_password_confirmation"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button id="updatePasswordButton" class="btn btn-primary mr-1 mt-1">{{__('Save')}}</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1">{{__('Reset')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="account-security" role="tabpanel" aria-labelledby="account-pill-security" aria-expanded="false">

                                @if($user->two_factor_secret)
                                    <h5 class="mb-2">{{ __('profile.Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}</h5>

                                    <button type="button" class="btn btn-relief-info" data-toggle="modal" data-target="#showDetails">{{__('profile.Show Details')}}</button>
                                    <button type="button" id="disable2FA" class="btn btn-relief-danger">{{__('profile.Disable 2FA')}}</button>
                                @else
                                    <h5>{{__('profile.You have not enabled two factor authentication.')}}</h5>
                                    <p>{{__("profile.When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.")}}</p>
                                    <button type="button" id="enable2FA" class="btn btn-relief-primary">{{__('profile.Enable 2FA')}}</button>
                                @endif
                                <div id="enabledButtons" class="hidden">
                                    <button type="button" class="btn btn-relief-info" data-toggle="modal" data-target="#showDetails">{{__('profile.Show Details')}}</button>
                                    <button type="button" id="disable2FA" class="btn btn-relief-danger">{{__('profile.Disable 2FA')}}</button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="account-sessions" role="tabpanel" aria-labelledby="account-pill-sessions" aria-expanded="false">

                                <p>
                                    {{ __('If necessary, you may logout of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
                                </p>
                                @if (count($user->getSessionsProperty()) > 0)
                                    <div class="mt-5 space-y-6">
                                        @foreach ($user->getSessionsProperty() as $session)
                                            <div class="flex items-center">
                                                <div>
                                                    @if ($session->agent->isDesktop())
                                                        <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                                            <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-gray-500">
                                                            <path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path>
                                                        </svg>
                                                    @endif
                                                </div>

                                                <div class="ml-3">
                                                    <div class="text-sm text-gray-600">
                                                        {{ $session->agent->platform() }} - {{ $session->agent->browser() }}
                                                    </div>

                                                    <div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $session->ip_address }},

                                                            @if ($session->is_current_device)
                                                                <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                                            @else
                                                                {{ __('Last active') }} {{ $session->last_active }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button id="killSessionsBtn" type="button" class="btn btn-relief-danger mt-2">{{__('Logout All Sessions')}}</button>
                                @endif

                            </div>

                            <div class="tab-pane fade" id="account-activity" role="tabpanel" aria-labelledby="account-pill-activity" aria-expanded="false">
                                <div class="row" id="table-hover-animation">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="card-text">
                                                    {{ __('You see sells which belongs to this stage') }}
                                                </p>

                                            </div>
                                            <div class="table-responsive">
                                                <table id="activityTable" class="invoice-list-table table table-hover table-hover-animation" data-page-length='10'>
                                                    <thead>
                                                    <tr>
                                                        <th>{{__('Description')}}</th>
                                                        <th>{{__('Details')}}</th>
                                                        <th>{{__('Timestamp')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(Auth::user()->activity as $activity)
                                                        <tr>
                                                            <td>{{ $activity->description }}</td>
                                                            <td>
                                                                @if($activity->log_name == 'login')
                                                                    <span class="badge badge-light-success text-capitalize">{{ $activity->getExtraProperty('interface') }}</span>
                                                                    <span class="badge badge-light-secondary text-capitalize">{{ $activity->getExtraProperty('IP') }}</span>
                                                                    <span class="badge badge-light-info text-capitalize">{{ $activity->getExtraProperty('browser') }}</span>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>{{ $activity->created_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade text-left modal-primary" id="showDetails" tabindex="-1" role="dialog" aria-labelledby="showDetails" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel160">{{__('profile.2FA Details')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="details2fa">

                    @if($user->two_factor_secret)
                        <div>
                            <h5>{{__('profile.2FA QR CODE')}}</h5>
                            {!! $user->twoFactorQrCodeSvg() !!}
                        </div>

                        <h5 class="mt-2">{{__('profile.Recovery Codes')}}</h5>
                        <p>{{ __('profile.Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}</p>
                        <div class="bg-gray-300 p-2">
                            @foreach (json_decode(decrypt($user->two_factor_recovery_codes), true) as $code)
                                <div>{{ $code }}</div>
                            @endforeach
                        </div>
                    @else
                        <div>
                            <h5>{{__('profile.2FA QR CODE')}}</h5>
                            <div id="qrcode"></div>
                        </div>

                        <h5 class="mt-2">{{__('profile.Recovery Codes')}}</h5>
                        <p>{{ __('profile.Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}</p>
                        <div class="bg-gray-300 p-2" id="recovery"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-scripts')
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#activityTable').DataTable({
            order: [[2, 'desc']],
            dom:
                '<"row d-flex justify-content-between align-items-center m-1"' +
                '<"col-lg-6 d-flex align-items-center"l<"dt-action-buttons text-xl-right text-lg-left text-lg-right text-left "B>>' +
                '<"col-lg-6 d-flex align-items-center justify-content-lg-end flex-lg-nowrap flex-wrap pr-lg-1 p-0"f<"invoice_status ml-sm-2">>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            buttons: [],
        });
    } );
</script>
<script>
    $(function () {
        'use strict';

        var accountUploadImg = $('#profile_photo_img'),
            ppUpload = $('#profile_photo'),
            accountResetBtn = $('#pp-reset');

        if (ppUpload) {
            ppUpload.on('change', function (e) {
                var reader = new FileReader(),
                    files = e.target.files;
                    reader.onload = function () {
                        if (accountUploadImg) {
                            accountUploadImg.attr('src', reader.result);
                    }
                };
                reader.readAsDataURL(files[0]);
            });
        }

        if(accountResetBtn) {
            accountResetBtn.on('click', function () {
                accountUploadImg.attr('src', '{{ $user->profile_photo_url }}');
            });
        }

        $('.select2').val('{{$user->country}}');
        $('.select2').trigger('change');

    });

</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#updatePasswordForm').on('submit', function(event){
        event.preventDefault();
        var error_current_password = $('#error_current_password');
        var error_password = $('#error_password');
        var error_password_confirmation = $('#error_password_confirmation');

        error_current_password.text('');
        error_password.text('');
        error_password_confirmation.text('');

        $.ajax({
            url: "{{route('user.profile.password')}}",
            type: "PUT",
            data: $(this).serialize(),
            success:function(response){
                if (response) {
                    $(document).ready(function() {
                        swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.success,
                            showConfirmButton: false,
                            timer: 1500,
                            buttonsStyling: false
                        });
                    });
                    $("#updatePasswordForm")[0].reset();
                }
            },
            error: function(response) {
                if (response.responseJSON.message) {
                    $(document).ready(function() {
                        swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.responseJSON.message,
                            showConfirmButton: false,
                            timer: 1500,
                            buttonsStyling: false
                        });
                    });
                    $("#updatePasswordForm")[0].reset();
                }
                if(response.responseJSON.errors.current_password)
                {
                    error_current_password.text(response.responseJSON.errors.current_password).show();
                }
                if(response.responseJSON.errors.password)
                {
                    error_password.text(response.responseJSON.errors.password).show();
                }
                if(response.responseJSON.errors.password_confirmation)
                {
                    error_password_confirmation.text(response.responseJSON.errors.password_confirmation).show();
                }
            }
        });
    });

    $('#killSessionsBtn').click(async function(event) {
        event.preventDefault();
        const { value: password } = await swal.fire({
            title: 'Enter your password',
            input: 'password',
            icon: 'question',
            inputPlaceholder: 'Enter your password',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            confirmButtonText: 'Confirm',
            showCancelButton: true,
        }).then((willKill) => {
            if (willKill.isConfirmed) {
                if (willKill.value) {
                    $.ajax({
                        url: "{{route('user.profile.logoutSessions')}}",
                        type: "POST",
                        data: {password: willKill.value},
                        success:function(response){
                            if (response.success) {
                                $(document).ready(function() {
                                    swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: response.success,
                                        showConfirmButton: false,
                                        timer: 1500,
                                        buttonsStyling: false
                                    });
                                });
                            }
                            if (response.message) {
                                $(document).ready(function() {
                                    swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 1500,
                                        buttonsStyling: false
                                    });
                                });
                            }
                        },
                        error: function(response) {
                            if (response.message) {
                                $(document).ready(function() {
                                    swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 1500,
                                        buttonsStyling: false
                                    });
                                });
                            }
                        }
                    });
                }
            }
        });
    });

    $('#enable2FA').click(async function(event) {
    event.preventDefault();
    const { value: password } = await swal.fire({
        title: 'Enter your password',
        input: 'password',
        icon: 'question',
        inputPlaceholder: 'Enter your password',
        inputAttributes: {
            autocapitalize: 'off',
            autocorrect: 'off'
        },
        confirmButtonText: 'Enable',
        showCancelButton: true,
    }).then((willEnable) => {
        if (willEnable.isConfirmed) {
            if (willEnable.value) {
                $.ajax({
                    url: "{{route('user.profile.enable2FA')}}",
                    type: "POST",
                    data: {password: willEnable.value},
                    success:function(response){
                        if (response.success) {
                            $(document).ready(function() {
                                swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: response.success,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    buttonsStyling: false
                                });
                            });
                            console.log(response);
                            $('#qrcode').html(response.qrcode)
                            var recoverycodes = '';
                            $.each(response.recovery, function (index,value) {
                                recoverycodes += '<div>'+ value +'</div>';
                            });
                            $('#recovery').html(recoverycodes)
                            $('#showDetails').modal('show');
                            $('#enable2FA').hide();
                            $('#enabledButtons').toggleClass('hidden');

                        }
                        if (response.message) {
                            $(document).ready(function() {
                                console.log(response);
                                swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    buttonsStyling: false
                                });
                            });
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    },
                    error: function(response) {
                        if (response.message) {
                            console.log(response);
                            $(document).ready(function() {
                                swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    buttonsStyling: false
                                });
                            });
                        }
                        window.setTimeout(function(){location.reload()},2000)
                    }
                });
            }
        }
        });
    });

    $('#disable2FA').click(async function(event) {
    event.preventDefault();
    const { value: password } = await swal.fire({
        title: 'Enter your password',
        input: 'password',
        icon: 'question',
        inputPlaceholder: 'Enter your password',
        inputAttributes: {
            autocapitalize: 'off',
            autocorrect: 'off'
        },
        confirmButtonText: 'Disable',
        showCancelButton: true,
    }).then((willDisable) => {
        if (willDisable.isConfirmed) {
            if (willDisable.value) {
                $.ajax({
                    url: "{{route('user.profile.disable2FA')}}",
                    type: "POST",
                    data: {password: willDisable.value},
                    success:function(response){
                        if (response.success) {
                            $(document).ready(function() {
                                swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: response.success,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    buttonsStyling: false
                                });
                            });
                        }
                        if (response.message) {
                            $(document).ready(function() {
                                swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    buttonsStyling: false
                                });
                            });
                        }
                        window.setTimeout(function(){location.reload()},2000)
                    },
                    error: function(response) {
                        if (response.message) {
                            $(document).ready(function() {
                                swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    buttonsStyling: false
                                });
                            });
                        }
                        window.setTimeout(function(){location.reload()},2000)
                    }
                });
            }
        }
    });
});

</script>
@endsection
