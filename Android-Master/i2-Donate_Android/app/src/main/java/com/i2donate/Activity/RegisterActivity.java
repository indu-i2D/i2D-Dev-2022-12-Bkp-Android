package com.i2donate.Activity;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.provider.Settings;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.view.WindowManager;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.facebook.AccessToken;
import com.facebook.CallbackManager;
import com.facebook.FacebookCallback;
import com.facebook.FacebookException;
import com.facebook.FacebookSdk;
import com.facebook.GraphRequest;
import com.facebook.GraphResponse;
import com.facebook.login.LoginManager;
import com.facebook.login.LoginResult;
import com.facebook.login.widget.LoginButton;
import com.google.android.gms.auth.api.Auth;
import com.google.android.gms.auth.api.signin.GoogleSignInAccount;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.auth.api.signin.GoogleSignInResult;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.ResultCallback;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.material.textfield.TextInputLayout;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.InstanceIdResult;
import com.google.firebase.messaging.FirebaseMessaging;
import com.google.gson.JsonObject;
import com.i2donate.Commonmethod.ConstantFunctions;
import com.i2donate.Commonmethod.SearchableSpinner;
import com.i2donate.Model.ChangeActivity;
import com.i2donate.Model.CurrencyBean;
import com.i2donate.R;
import com.i2donate.RetrofitAPI.ApiClient;
import com.i2donate.RetrofitAPI.ApiInterface;
import com.i2donate.Session.IDonateSharedPreference;
import com.i2donate.Session.SessionManager;
import com.i2donate.Validation.Validation;
import com.twitter.sdk.android.core.Result;
import com.twitter.sdk.android.core.TwitterApiClient;
import com.twitter.sdk.android.core.TwitterCore;
import com.twitter.sdk.android.core.TwitterException;
import com.twitter.sdk.android.core.TwitterSession;
import com.twitter.sdk.android.core.identity.TwitterAuthClient;
import com.twitter.sdk.android.core.identity.TwitterLoginButton;
import com.twitter.sdk.android.core.models.User;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;

import butterknife.BindView;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class RegisterActivity extends AppCompatActivity implements
        GoogleApiClient.OnConnectionFailedListener {
    private static final String TAG = RegisterActivity.class.getSimpleName();
    private static final int RC_SIGN_IN = 007;
    ImageView back_icon_img;
    TextView login_btn_tv;
    @BindView(R.id.name_input_layout)
    TextInputLayout name_input_layout;
    @BindView(R.id.email_input_layout)
    TextInputLayout email_input_layout;
    @BindView(R.id.mobile_input_layout)
    TextInputLayout mobile_input_layout;
    @BindView(R.id.password_input_layout)
    TextInputLayout password_input_layout;
    @BindView(R.id.confirm_input_layout)
    TextInputLayout confirm_input_layout;
    @BindView(R.id.business_name_input_layout)
    TextInputLayout business_name_input_layout;
    EditText reg_name_et, reg_email_et, reg_mobile_et, reg_password_et, reg_confirm_password_et, business_reg_name_et;
    SearchableSpinner country_spinner;
    Button register_btn;
    TextView iagree_tv;
    private final static String API_KEY = "";
    ArrayList<String> country = new ArrayList<>();
    ArrayList<String> country_name_id = new ArrayList<String>();
    ArrayList<CurrencyBean> country1 = new ArrayList<CurrencyBean>();
    List<CurrencyBean> country_name_list = new ArrayList<CurrencyBean>();
    ApiInterface apiService;
    String country_name;
    JSONArray jsonArray;
    ImageView back_icon_login_img, google_sign_btn, facebook_login, twitter_login;
    LoginButton facebook_login_btn;
    private GoogleApiClient mGoogleApiClient;
    CallbackManager callbackManager;
    private final String PACKAGE = "com.i2donate";
    RadioButton radio_btn_male, radio_btn_female, radio_btn_orthers, radio_btn_yes, radio_btn_no;
    String radi_gender = "";
    String radi_business = "";
    CheckBox checkbox_btn;
    String country_symbol = "";
    SessionManager sessionManager;
    IDonateSharedPreference iDonateSharedPreference;
    private LinearLayout register_gender_layout;
    String type = "";
    String business_name = "";
    TwitterLoginButton twitter_login_btn;
    private TwitterAuthClient client;
    String device_token;
    LinearLayout terms_layout;
    int user_id;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        // getWindow().setBackgroundDrawableResource(R.drawable.dashbord_background);
        getWindow().setSoftInputMode(
                WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN);
        CountryAPI();
        init();
        getToken();
        listioner();
    }

    private void CountryAPI() {
        country.clear();
        country_name_id.clear();
        country_name_list.clear();
        JsonObject jsonObject1 = new JsonObject();
        jsonObject1.addProperty("email", API_KEY);
        apiService =
                ApiClient.getClient().create(ApiInterface.class);

        Call<JsonObject> call = apiService.countryAPI(jsonObject1);
        call.enqueue(new Callback<JsonObject>() {
            @Override
            public void onResponse(Call<JsonObject> call, Response<JsonObject> response) {
                Log.e(TAG, "123" + response);
                try {
                    JSONObject jsonObject = new JSONObject(String.valueOf(response.body()));
                    Log.e(TAG, "123" + jsonObject);
                    String message = jsonObject.getString("message");
                    Log.e(TAG, "" + message);
                    if (jsonObject.getString("status").equals("1")) {
                        String data = jsonObject.getString("data");
                        jsonArray = new JSONArray(data);
                        Log.e(TAG, "" + jsonArray);
                        HashMap<String, String> map = new HashMap<>();

                        for (int i = 0; i < jsonArray.length(); i++) {

                            JSONObject countryobject = jsonArray.getJSONObject(i);
                            CurrencyBean ctb = new CurrencyBean();
                            country.add(countryobject.getString("name"));
                            ctb.setCurrency_id(countryobject.getString("sortname"));
                            ctb.setCurrency_name(countryobject.getString("name"));
                            country_name_id.add(countryobject.getString("sortname"));
                            country_name_list.add(ctb);
                            country1.add(ctb);
                            if (countryobject.getString("name").equalsIgnoreCase("United States")) {

                                country_spinner.setDefaultText(countryobject.getString("name"));
                                country_symbol = countryobject.getString("sortname");
                            }
                            //  country_name_list.add(countryobject.getString("sortname"));

                        }
                       /* ArrayAdapter<String> from_names_adapter = new ArrayAdapter<String>(RegisterActivity.this, android.R.layout.simple_spinner_item, country);
                        from_names_adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                        country_spinner.setAdapter(from_names_adapter);*/
                        country_spinner.setData(country);

                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }


            }

            @Override
            public void onFailure(Call<JsonObject> call, Throwable t) {
                // Log error here since request failed
                Log.e(TAG, t.toString());
            }
        });
    }

    private void init() {
        iDonateSharedPreference = new IDonateSharedPreference();
        sessionManager = new SessionManager(getApplicationContext());
        back_icon_img = (ImageView) findViewById(R.id.back_icon_img);
        login_btn_tv = (TextView) findViewById(R.id.login_btn_tv);
        reg_name_et = (EditText) findViewById(R.id.reg_name_et);
        name_input_layout = (TextInputLayout) findViewById(R.id.name_input_layout);
        reg_email_et = (EditText) findViewById(R.id.reg_email_et);
        email_input_layout = (TextInputLayout) findViewById(R.id.email_input_layout);
        reg_mobile_et = (EditText) findViewById(R.id.reg_mobile_et);
        mobile_input_layout = (TextInputLayout) findViewById(R.id.mobile_input_layout);
        reg_password_et = (EditText) findViewById(R.id.reg_password_et);
        password_input_layout = (TextInputLayout) findViewById(R.id.password_input_layout);
        reg_confirm_password_et = (EditText) findViewById(R.id.reg_confirm_password_et);
        confirm_input_layout = (TextInputLayout) findViewById(R.id.confirm_input_layout);
        country_spinner = (SearchableSpinner) findViewById(R.id.spin_country);
        register_btn = (Button) findViewById(R.id.register_btn);
        radio_btn_male = (RadioButton) findViewById(R.id.radio_btn_male);
        twitter_login_btn = (TwitterLoginButton) findViewById(R.id.twitter_login_btn);
        radio_btn_female = (RadioButton) findViewById(R.id.radio_btn_female);
        radio_btn_orthers = (RadioButton) findViewById(R.id.radio_btn_orthers);
        checkbox_btn = (CheckBox) findViewById(R.id.checkbox_btn);
        business_reg_name_et = (EditText) findViewById(R.id.business_reg_name_et);
        business_name_input_layout = (TextInputLayout) findViewById(R.id.business_name_input_layout);
        radio_btn_yes = (RadioButton) findViewById(R.id.radio_btn_yes);
        radio_btn_no = (RadioButton) findViewById(R.id.radio_btn_no);
        google_sign_btn = (ImageView) findViewById(R.id.google_sign_btn);
        facebook_login = (ImageView) findViewById(R.id.facebook_login);
        twitter_login = (ImageView) findViewById(R.id.twitter_login);
        facebook_login_btn = (LoginButton) findViewById(R.id.facebook_login_btn);
        register_gender_layout = (LinearLayout) findViewById(R.id.register_gender_layout);
        terms_layout = (LinearLayout) findViewById(R.id.terms_layout);
        iagree_tv = (TextView) findViewById(R.id.iagree_tv);
      /*  try {
            Field popup = Spinner.class.getDeclaredField("mPopup");
            popup.setAccessible(true);

            // Get private mPopup member variable and try cast to ListPopupWindow
            android.widget.ListPopupWindow popupWindow = (android.widget.ListPopupWindow) popup.get(country_spinner);

            // Set popupWindow height to 500px
            popupWindow.setHeight(80);
        }
        catch (NoClassDefFoundError | ClassCastException | NoSuchFieldException | IllegalAccessException e) {
            // silently fail...
        }*/

        GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DEFAULT_SIGN_IN)
                .requestEmail()
                .build();

        mGoogleApiClient = new GoogleApiClient.Builder(this)
                .enableAutoManage(this, this)
                .addApi(Auth.GOOGLE_SIGN_IN_API, gso)
                .build();
        FacebookSdk.sdkInitialize(getApplicationContext());
        LoginManager.getInstance().logOut();


        /*Facebook login*/

        boolean loggedOut = AccessToken.getCurrentAccessToken() == null;

      /*  if (!loggedOut) {

            Log.d("TAG", "Username is: " + Profile.getCurrentProfile().getName());


            getUserProfile(AccessToken.getCurrentAccessToken());
        }
*/
        facebook_login_btn.setReadPermissions(Arrays.asList("email", "public_profile"));
        callbackManager = CallbackManager.Factory.create();
        client = new TwitterAuthClient();
       /* facebook_login_btn.registerCallback(callbackManager, new FacebookCallback<LoginResult>() {
            @Override
            public void onSuccess(LoginResult loginResult) {

                getUserProfile(AccessToken.getCurrentAccessToken());
                Log.e("click", "click");
                boolean loggedIn = AccessToken.getCurrentAccessToken() == null;
               Log.d("API123", loggedIn + " ??");

            }

            @Override
            public void onCancel() {

                Log.e("click", "click1");
                // App code
            }

            @Override
            public void onError(FacebookException exception) {

                Log.e("click", "click2" + exception);

                // App code
            }
        });*/
        facebook_login_btn.registerCallback(callbackManager, new FacebookCallback<LoginResult>() {
            @Override
            public void onSuccess(LoginResult loginResult) {

                getUserProfile(AccessToken.getCurrentAccessToken());
                Log.e("click", "click");

                // App code
            }

            @Override
            public void onCancel() {
                Log.e("click", "click");
                // App code
            }

            @Override
            public void onError(FacebookException exception) {
                Log.e("click", "click");
                // App code
            }
        });

    }

    private void listioner() {
        twitter_login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (isOnline()) {
                    defaultLoginTwitter();
                    Log.e("click", "click243");

                } else {
                    //Toast.makeText(LoginActivity.this, "Please check internet connection", Toast.LENGTH_SHORT).show();
                    ConstantFunctions.showSnakBar("Please check internet connection", v);
                }

            }
        });
        back_icon_img.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });
        login_btn_tv.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ChangeActivity.changeActivity(RegisterActivity.this, LoginActivity.class);
                finish();
            }
        });
        radio_btn_no.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (radio_btn_no.isChecked()) {
                    radi_business = "yes";
                    type = "business";
                    register_gender_layout.setVisibility(View.GONE);
                    radi_gender = "";
                    business_name = business_reg_name_et.getText().toString();
                    business_name_input_layout.setVisibility(View.VISIBLE);
                } else {
                    register_gender_layout.setVisibility(View.VISIBLE);
                    business_reg_name_et.setText("");
                    type = "Individual";
                    if (radio_btn_male.isChecked()) {
                        radi_gender = "M";
                    } else if (radio_btn_female.isChecked()) {
                        radi_gender = "F";
                    } else if (radio_btn_orthers.isChecked()) {
                        radi_gender = "O";
                    } else {

                        radi_gender = "";
                    }
                    business_name_input_layout.setVisibility(View.GONE);
                }
            }
        });
        radio_btn_yes.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (radio_btn_yes.isChecked()) {
                    radi_business = "no";
                    type = "Individual";
                    business_reg_name_et.setText("");
                    register_gender_layout.setVisibility(View.VISIBLE);
                    business_name_input_layout.setVisibility(View.GONE);
                    if (radio_btn_male.isChecked()) {
                        radi_gender = "M";
                    } else if (radio_btn_female.isChecked()) {
                        radi_gender = "F";
                    } else if (radio_btn_orthers.isChecked()) {
                        radi_gender = "O";
                    } else {

                        radi_gender = "";
                    }
                } else {
                    type = "business";
                    radi_gender = "";
                    business_name = business_reg_name_et.getText().toString();
                    register_gender_layout.setVisibility(View.GONE);
                    business_name_input_layout.setVisibility(View.VISIBLE);
                }
            }
        });
        reg_name_et.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int start, int before, int count) {

                if (charSequence.toString().startsWith(" ")) {
                    reg_name_et.setText("");
                    Toast.makeText(getApplicationContext(), "Space Not allowed", Toast.LENGTH_LONG).show();
                    name_input_layout.setError("Required name");
                    //disableButton(...)
                } else {
                    if (reg_name_et.getText().toString().trim().length() <= 0) {
                        name_input_layout.setError("Required name");
                    } else {
                        name_input_layout.setError("");

                    }
                    //Toast.makeText(getApplicationContext(), " allowed", Toast.LENGTH_LONG).show();
                    //enableButton(...)
                }
            }

            @Override
            public void afterTextChanged(Editable s) {
                if (radi_business.equals("no")) {
                    Log.e(TAG, "afterTextChanged:yes");
                    if (s.toString().matches(Validation.NAME_PATTERN)) {
                        name_input_layout.setError("");
                    } else {
                        name_input_layout.setError("Name is invalid");
                    }
                } else if (radi_business.equals("yes")) {
                    Log.e(TAG, "afterTextChanged:no ");
                    if (s.toString().matches(Validation.NAME_PATTERN)) {
                        name_input_layout.setError("");
                    } else {
                        name_input_layout.setError("Name is invalid");
                    }
                } else {
                    if (s.toString().matches(Validation.NAMEPATTERN)) {
                        name_input_layout.setError("");
                    } else {
                        name_input_layout.setError("Name is invalid");
                    }
                }
            }
        });

        reg_email_et.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int start, int before, int count) {
                if (charSequence.toString().startsWith(" ")) {
                    reg_email_et.setText("");
                    Toast.makeText(getApplicationContext(), "Space Not allowed", Toast.LENGTH_LONG).show();
                    email_input_layout.setError("Required email");
                    //disableButton(...)
                } else {
                    email_input_layout.setError("");
                    if (reg_name_et.getText().toString().trim().length() <= 0) {
                        name_input_layout.setError("Required name");
                    } else {
                        name_input_layout.setError("");
                        if (reg_email_et.getText().toString().trim().length() <= 0) {
                            email_input_layout.setError("Required username");
                        } else {
                            if (reg_email_et.getText().toString().trim().matches(Validation.emailPattern)) {
                                email_input_layout.setError("");
                            } else {
                                email_input_layout.setError("Required email");
                            }

                        }
                    }

                    //Toast.makeText(getApplicationContext(), " allowed", Toast.LENGTH_LONG).show();
                    //enableButton(...)
                }
            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });
        reg_email_et.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if (reg_name_et.getText().toString().trim().length() <= 0) {
                    name_input_layout.setError("Required name");
                } else {
                    name_input_layout.setError("");

                }
                return false;
            }
        });
        reg_mobile_et.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int start, int before, int count) {
                if (charSequence.toString().startsWith(" ")) {
                    reg_mobile_et.setText("");
                    Toast.makeText(getApplicationContext(), "Space Not allowed", Toast.LENGTH_LONG).show();
                    // mobile_input_layout.setError("Required mobile number");
                    //disableButton(...)
                } else {

                    if (reg_email_et.getText().toString().trim().length() <= 0) {
                        email_input_layout.setError("Required email");
                    } else {
                        if (reg_email_et.getText().toString().trim().matches(Validation.emailPattern)) {
                            email_input_layout.setError("");
                          /*  if (reg_mobile_et.getText().toString().trim().length() <= 0) {
                              //  mobile_input_layout.setError("Required mobile number");
                            } else {
                               // mobile_input_layout.setError("");

                            }*/
                        } else {
                            email_input_layout.setError("Required email");
                        }

                    }
                    //Toast.makeText(getApplicationContext(), " allowed", Toast.LENGTH_LONG).show();
                    //enableButton(...)
                }
            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });
        reg_mobile_et.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if (reg_email_et.getText().toString().trim().length() <= 0) {
                    email_input_layout.setError("Required email");
                } else {
                    if (reg_email_et.getText().toString().trim().matches(Validation.emailPattern)) {
                        email_input_layout.setError("");
                    } else {
                        email_input_layout.setError("Required email");
                    }

                }
                return false;
            }
        });
        reg_password_et.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int start, int before, int count) {
                if (charSequence.toString().startsWith(" ")) {
                    reg_password_et.setText("");
                    Toast.makeText(getApplicationContext(), "Space Not allowed", Toast.LENGTH_LONG).show();
                    password_input_layout.setError("Required password");
                    //disableButton(...)
                } else {
                    if (reg_password_et.getText().toString().trim().length() <= 0) {
                        password_input_layout.setError("Required password");
                    } else {
                        password_input_layout.setError("");

                    }
                   /* if (reg_mobile_et.getText().toString().trim().length() <= 0) {
                        mobile_input_layout.setError("Required email");
                    } else {
                        mobile_input_layout.setError("");
                        if (reg_password_et.getText().toString().trim().length() <= 0) {
                            password_input_layout.setError("Required mobile number");
                        } else {
                            password_input_layout.setError("");

                        }
                    }*/
                    //Toast.makeText(getApplicationContext(), " allowed", Toast.LENGTH_LONG).show();
                    //enableButton(...)
                }
            }

            @Override
            public void afterTextChanged(Editable s) {
                String passwordvalidation = s.toString();
                if (passwordvalidation.length() >= 8 && passwordvalidation.matches(Validation.PASSWORD_PATTERN)) {
                    password_input_layout.setError("");
                } else {
                    password_input_layout.setError("Password is invalid");
                }

            }
        });

       /* reg_password_et.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if (reg_mobile_et.getText().toString().trim().length() <= 0) {
                    mobile_input_layout.setError("Required mobile number");
                } else {
                    mobile_input_layout.setError("");

                }
                return false;
            }
        });*/
        reg_confirm_password_et.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int start, int before, int count) {
                if (charSequence.toString().startsWith(" ")) {
                    reg_confirm_password_et.setText("");
                    Toast.makeText(getApplicationContext(), "Space Not allowed", Toast.LENGTH_LONG).show();
                    confirm_input_layout.setError("Required password");
                    //disableButton(...)
                } else {

                    if (reg_password_et.getText().toString().trim().length() <= 0) {
                        password_input_layout.setError("Required email");
                    } else {
                        password_input_layout.setError("");
                        if (reg_confirm_password_et.getText().toString().trim().length() <= 0) {
                            confirm_input_layout.setError("Required password");
                        } else {
                            confirm_input_layout.setError("");

                        }
                    }
                }
            }

            @Override
            public void afterTextChanged(Editable s) {
                if (reg_password_et.getText().toString().trim().equals(reg_confirm_password_et.getText().toString().trim())) {

                } else {
                    confirm_input_layout.setError("Required correct password");
                }

            }
        });
        reg_confirm_password_et.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if (reg_password_et.getText().toString().trim().length() <= 0) {
                    password_input_layout.setError("Required password");
                } else {
                    password_input_layout.setError("");

                }
                return false;
            }
        });
        iagree_tv.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (checkbox_btn.isChecked()) {
                    checkbox_btn.setChecked(false);
                } else {
                    checkbox_btn.setChecked(true);
                }
            }
        });
        terms_layout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ChangeActivity.changeActivityData(RegisterActivity.this, TermsAndConditionActivity.class, "");
            }
        });
        register_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (!reg_name_et.getText().toString().trim().isEmpty() && !reg_email_et.getText().toString().trim().isEmpty() && !reg_mobile_et.getText().toString().trim().isEmpty() && !reg_password_et.getText().toString().trim().isEmpty()) {
                    if (reg_email_et.getText().toString().trim().matches(Validation.emailPattern)) {
                        // if (reg_password_et.getText().toString().trim().equals(reg_confirm_password_et.getText().toString().trim())) {
                        if (reg_password_et.getText().toString().trim().matches(Validation.PASSWORD_PATTERN) && reg_password_et.getText().toString().trim().length() >= 8) {

                            radiofn();
                            radiobussi();
                            /// if (!radi_gender.isEmpty()) {
                            if (!radi_business.isEmpty()) {
                                if (checkbox_btn.isChecked()) {
                                    if (radi_business.equals("no")) {
                                        if (!country_symbol.isEmpty()) {

                                            if (isOnline()) {

                                                RegisterAPI();

                                            } else {
                                                //Toast.makeText(LoginActivity.this, "Please check internet connection", Toast.LENGTH_SHORT).show();
                                                ConstantFunctions.showSnakBar("Please check internet connection", v);
                                            }
                                        } else {
                                            Toast.makeText(RegisterActivity.this, "Select country", Toast.LENGTH_SHORT).show();
                                        }
                                    } else {
                                        if (reg_name_et.getText().toString().toString().trim().matches(Validation.NAME_PATTERN)) {
                                            if (!country_symbol.isEmpty()) {

                                                if (isOnline()) {

                                                    RegisterAPI();

                                                } else {
                                                    //Toast.makeText(LoginActivity.this, "Please check internet connection", Toast.LENGTH_SHORT).show();
                                                    ConstantFunctions.showSnakBar("Please check internet connection", v);
                                                }
                                            } else {
                                                Toast.makeText(RegisterActivity.this, "Select country", Toast.LENGTH_SHORT).show();
                                            }
                                        } else {
                                            Toast.makeText(RegisterActivity.this, "Name format is invalid", Toast.LENGTH_SHORT).show();
                                        }
                                    }

                                } else {
                                    Toast.makeText(RegisterActivity.this, "Please accept our Terms and Conditions", Toast.LENGTH_SHORT).show();
                                }

                            } else {
                                Toast.makeText(RegisterActivity.this, "Please select Register as Individual / Business", Toast.LENGTH_SHORT).show();
                            }

                           /* } else {
                                Toast.makeText(RegisterActivity.this, "Please select gender", Toast.LENGTH_SHORT).show();
                            }*/
                        } else {
                            password_input_layout.setError("Password format is invalid");
                            Toast.makeText(RegisterActivity.this, "Password format is invalid", Toast.LENGTH_SHORT).show();
                        }
                       /* } else {
                            Toast.makeText(RegisterActivity.this, "Verify password", Toast.LENGTH_SHORT).show();
                        }*/


                    } else {
                        Toast.makeText(RegisterActivity.this, "Enter Correct Mail ID", Toast.LENGTH_SHORT).show();
                    }
                } else {
                    Toast.makeText(RegisterActivity.this, "Please fill all the fields", Toast.LENGTH_SHORT).show();
                }
            }
        });
        country_spinner.setSelectionListener(new SearchableSpinner.OnSelectionListener() {
            @Override
            public void onSelect(int spinnerId, int i, String value) {
                Log.e("Select2", "Position : " + i + " : Value : " + value + " : " + spinnerId);
                InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
                imm.hideSoftInputFromWindow(country_spinner.getWindowToken(),
                        InputMethodManager.RESULT_UNCHANGED_SHOWN);
                for (int i1 = 0; i1 < jsonArray.length(); i1++) {

                    JSONObject countryobject = null;
                    try {
                        countryobject = jsonArray.getJSONObject(i1);
                        if (countryobject.getString("name").equals(value)) {
                            country_symbol = countryobject.getString("sortname");
                            Log.e(TAG, country_symbol);
                        }
                    } catch (JSONException e) {


                    }


                }


            }
        });


        google_sign_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (isOnline()) {

                    signIn();

                } else {
                    //Toast.makeText(LoginActivity.this, "Please check internet connection", Toast.LENGTH_SHORT).show();
                    ConstantFunctions.showSnakBar("Please check internet connection", v);
                }

            }
        });

        facebook_login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (isOnline()) {

                    facebook_login_btn.performClick();
                    Log.e("click", "click243");

                } else {
                    //Toast.makeText(LoginActivity.this, "Please check internet connection", Toast.LENGTH_SHORT).show();
                    ConstantFunctions.showSnakBar("Please check internet connection", v);
                }

            }
        });

    }

    private TwitterSession getTwitterSession() {
        TwitterSession session = TwitterCore.getInstance().getSessionManager().getActiveSession();
        //NOTE : if you want to get token and secret too use uncomment the below code
        /*TwitterAuthToken authToken = session.getAuthToken();
        String token = authToken.token;
        String secret = authToken.secret;*/

        return session;
    }

    public void fetchTwitterEmail(final TwitterSession twitterSession) {
        client.requestEmail(twitterSession, new com.twitter.sdk.android.core.Callback<String>() {
            @Override
            public void success(Result<String> result) {
                //here it will give u only email and rest of other information u can get from TwitterSession
//                Log.e(TAG, result.data);
                /*Toast.makeText(LoginActivity.this, "User Id : " + twitterSession.getUserId() + "\nScreen Name : " + twitterSession.getUserName() + "\nEmail Id : " + result.data, Toast.LENGTH_SHORT).show();
                Log.e(TAG,"User Id : " + twitterSession.getUserId()+ "\nUser Name : " + twitterSession.getUserName() + "\nEmail Id : " +  result.data);*/
                fetchTwitterImage();
            }

            @Override
            public void failure(TwitterException exception) {
                Toast.makeText(RegisterActivity.this, "Failed to authenticate. Please try again.", Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void getToken() {

        FirebaseMessaging.getInstance().setAutoInitEnabled(true);

        FirebaseInstanceId.getInstance().getInstanceId()
                .addOnCompleteListener(new OnCompleteListener<InstanceIdResult>() {
                    @Override
                    public void onComplete(@NonNull com.google.android.gms.tasks.Task<InstanceIdResult> task) {
                        if (!task.isSuccessful()) {
                            Log.e("token", "getInstanceId failed", task.getException());
                            return;
                        }

                        // Get new Instance ID token
                        device_token = task.getResult().getToken();

                        // Log and toast
//                        String msg = getString(R.string.msg_token_fmt, token);
                        Log.e("device_token", "" + device_token);
                        //  Toast.makeText(SplashActivity.this, token, Toast.LENGTH_SHORT).show();
                    }
                });
    }

    private void sentdevicetoken(final String type) {
        int status = iDonateSharedPreference.getNotificationstatus(getApplicationContext());
        JsonObject jsonObject1 = new JsonObject();
        jsonObject1.addProperty("user_id", user_id);
        jsonObject1.addProperty("device_id", device_token);
        jsonObject1.addProperty("enable_notification", status);
        Log.e("jsonObject1", "" + jsonObject1);
        /*   ApiInterface jsonPostService = ApiClient.createService(ApiInterface.class, "http://project975.website/i2-donate/api/");*/
        final String image_url = "";
        apiService =
                ApiClient.getClient().create(ApiInterface.class);
        try {
            Call<JsonObject> call = apiService.device_update(jsonObject1);
            call.enqueue(new retrofit2.Callback<JsonObject>() {
                @Override
                public void onResponse(Call<JsonObject> call, Response<JsonObject> response) {
                    Log.e(TAG, "" + response.body());
                    try {
                        JSONObject jsonObject = new JSONObject(String.valueOf(response.body()));
                        String status = jsonObject.getString("status");
                        String message = jsonObject.getString("message");
                        String data = jsonObject.getString("data");
                        iDonateSharedPreference.settoken(getApplicationContext(), device_token);
                        if (status.equalsIgnoreCase("1")) {
                            final JSONObject jsonObject2 = new JSONObject(data);
                            if (type.equalsIgnoreCase("social")) {
                                ChangeActivity.changeActivity(RegisterActivity.this, UpdateActivity.class);
                                finish();
                            } else {
                                finish();
                            }


                        } else {
                            // ConstantFunctions.showSnackbar(reg_email_et,message,ForgotActivity.this);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }

                }

                @Override
                public void onFailure(Call<JsonObject> call, Throwable t) {
                    Log.e(TAG, t.toString());
                }
            });
        } catch (Exception e) {
            e.printStackTrace();
            Log.e("Exception", "" + e);
        }
    }

    public void fetchTwitterImage() {
        //check if user is already authenticated or not
        if (getTwitterSession() != null) {

            //fetch twitter image with other information if user is already authenticated

            //initialize twitter api client
            TwitterApiClient twitterApiClient = TwitterCore.getInstance().getApiClient();

            //Link for Help : https://developer.twitter.com/en/docs/accounts-and-users/manage-account-settings/api-reference/get-account-verify_credentials

            //pass includeEmail : true if you want to fetch Email as well
            Call<User> call = twitterApiClient.getAccountService().verifyCredentials(true, false, true);
            call.enqueue(new com.twitter.sdk.android.core.Callback<User>() {
                @Override
                public void success(Result<User> result) {
                    User user = result.data;
                    Log.e(TAG, "User Id : " + user.id + "\nUser Name : " + user.name + "\nEmail Id : " + user.email + "\nScreen Name : " + user.screenName);

                    String imageProfileUrl = user.profileImageUrl;
                    Log.e(TAG, "Data : " + imageProfileUrl);
                    if (user.email == null) {
                        gmailfacebookloginAPI(user.name, "", "twitter", user.profileImageUrl);
                    } else
                        gmailfacebookloginAPI(user.name, user.email, "twitter", user.profileImageUrl);
                    //NOTE : User profile provided by twitter is very small in size i.e 48*48
                    //Link : https://developer.twitter.com/en/docs/accounts-and-users/user-profile-images-and-banners
                    //so if you want to get bigger size image then do the following:
                    imageProfileUrl = imageProfileUrl.replace("_normal", "");

                    ///load image using Picasso
                   /* Picasso.with(MainActivity.this)
                            .load(imageProfileUrl)
                            .placeholder(R.mipmap.ic_launcher_round)
                            .into(userProfileImageView);*/
                }

                @Override
                public void failure(TwitterException exception) {
                    Toast.makeText(RegisterActivity.this, "Failed to authenticate. Please try again.", Toast.LENGTH_SHORT).show();
                }
            });
        } else {
            //if user is not authenticated first ask user to do authentication
            Toast.makeText(this, "First to Twitter auth to Verify Credentials.", Toast.LENGTH_SHORT).show();
        }

    }

    private void defaultLoginTwitter() {
        //check if user is already authenticated or not
        if (getTwitterSession() == null) {

            Log.e(TAG, "getTwitterSession is null");

            //if user is not authenticated start authenticating
            twitter_login_btn.setCallback(new com.twitter.sdk.android.core.Callback<TwitterSession>() {


                @Override
                public void success(Result<TwitterSession> result) {

                    // Do something with result, which provides a TwitterSession for making API calls
                    TwitterSession twitterSession = result.data;

                    Log.e(TAG, "Success : " + result.data);

                    //call fetch email only when permission is granted
                    fetchTwitterEmail(twitterSession);

                }

                @Override
                public void failure(TwitterException exception) {
                    // Do something on failure
                    Toast.makeText(RegisterActivity.this, "Failed to authenticate. Please try again.", Toast.LENGTH_SHORT).show();
                }
            });
            twitter_login_btn.performClick();
        } else {

            //if user is already authenticated direct call fetch twitter email api
//            Toast.makeText(this, "User already authenticated", Toast.LENGTH_SHORT).show();
            fetchTwitterEmail(getTwitterSession());
        }

    }

    private void signIn() {
        Intent signInIntent = Auth.GoogleSignInApi.getSignInIntent(mGoogleApiClient);
        startActivityForResult(signInIntent, RC_SIGN_IN);

    }

    private void handleSignInResult(GoogleSignInResult result) {
        Log.e(TAG, "handleSignInResult:" + result.isSuccess());
        if (result.isSuccess()) {
            // Signed in successfully, show authenticated UI.
            GoogleSignInAccount acct = result.getSignInAccount();
            Log.e("acct", "" + acct);
            Log.e(TAG, "display name: " + acct.getDisplayName());
            try {
                String personName = acct.getDisplayName();
                String personPhotoUrl = "";
                try {
                    personPhotoUrl = acct.getPhotoUrl().toString();
                } catch (Exception e) {
                    e.printStackTrace();

                }

                String email = acct.getEmail();


                Log.e(TAG, "Name: " + personName + ", email: " + email
                        + ", Image: " + "" + personPhotoUrl);
                String socialmedia = "email";
                gmailfacebookloginAPI(personName, email, socialmedia, personPhotoUrl);


            } catch (Exception e) {

                e.printStackTrace();
            }


        } else {

            // Signed out, show unauthenticated UI.

        }
    }

    private void gmailfacebookloginAPI(final String name, final String personName, final String socialmedia, final String image_url) {
        Log.e("socialmedia", "" + image_url);
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Loading...");
        progressDialog.show();
        JsonObject jsonObject1 = new JsonObject();
        jsonObject1.addProperty("name", name);
        jsonObject1.addProperty("email", personName);
        jsonObject1.addProperty("device_id", getDeviceUniqueID(RegisterActivity.this));
        jsonObject1.addProperty("login_type", socialmedia);
        jsonObject1.addProperty("photo", image_url);
        jsonObject1.addProperty("terms", "");

        Log.e("jsonObject1", "" + jsonObject1);
        /*   ApiInterface jsonPostService = ApiClient.createService(ApiInterface.class, "http://project975.website/i2-donate/api/");*/
        apiService =
                ApiClient.getClient().create(ApiInterface.class);
        try {
            Call<JsonObject> call = apiService.socialmedialogin(jsonObject1);
            call.enqueue(new Callback<JsonObject>() {
                @Override
                public void onResponse(Call<JsonObject> call, Response<JsonObject> response) {
                    progressDialog.dismiss();

                    Log.e(TAG, "" + response.body());
                    Log.e("response", "" + response);
                    iDonateSharedPreference.setsocialmedia(getApplicationContext(), socialmedia);
                    try {
                        JSONObject jsonObject = new JSONObject(String.valueOf(response.body()));
                        String message = jsonObject.getString("message");
                        Log.e("response", "" + message);
                        if (jsonObject.getString("status").equals("1")) {
                            Log.e("socialmedia11", "" + socialmedia);
                            iDonateSharedPreference.setName(getApplicationContext(), name);
                            iDonateSharedPreference.setMail(getApplicationContext(), personName);
                            iDonateSharedPreference.setsocialmedia(getApplicationContext(), socialmedia);
                            iDonateSharedPreference.setSocialProfileimg(getApplicationContext(), image_url);
                            String data = jsonObject.getString("data");
                            Log.e("data232", "" + data);
                            JSONObject jsonObject1 = new JSONObject(data);
                            Log.e("data232", "" + jsonObject1);
                            iDonateSharedPreference.seteditprofile(getApplicationContext(), "2");
                            iDonateSharedPreference.setprofiledata(getApplicationContext(), data);
                            iDonateSharedPreference.setlogintype(getApplicationContext(), "sociallogin");
                            sessionManager.createLoginSession(jsonObject1.getString("user_id"), jsonObject1.getString("email"), jsonObject1.getString("name"), jsonObject1.getString("phone_number"), jsonObject1.getString("photo"), jsonObject1.getString("token"), jsonObject1.getString("business_name"), jsonObject1.getString("country"), jsonObject1.getString("gender"), jsonObject1.getString("type"));
                            user_id = Integer.parseInt(jsonObject1.getString("user_id"));
                            Log.e("response_name", "" + iDonateSharedPreference.getName(getApplicationContext()));
                            Toast.makeText(RegisterActivity.this, message, Toast.LENGTH_SHORT).show();
                            // iDonateSharedPreference.seteditprofile(getApplicationContext(), "0");
                            sentdevicetoken("social");
                        } else if (jsonObject.getString("status").equals("0")) {
                            // Toast.makeText(LoginActivity.this, message, Toast.LENGTH_SHORT).show();
                            ConstantFunctions.showSnackbar(reg_name_et, message, RegisterActivity.this);
                            if (iDonateSharedPreference.getsocialMedia(getApplicationContext()).equalsIgnoreCase("email")) {
                                Log.e("data232email", "" + "email");
                                signOut();
                                // Toast.makeText(LoginActivity.this, message, Toast.LENGTH_SHORT).show();
                            } else if (iDonateSharedPreference.getsocialMedia(getApplicationContext()).equalsIgnoreCase("facebook")) {
                                Log.e("data232facebook", "" + "facebook");
                                FacebookSdk.sdkInitialize(getApplicationContext());
                                LoginManager.getInstance().logOut();

                            }

                        }
                    } catch (JSONException e) {


                    }

                }

                @Override
                public void onFailure(Call<JsonObject> call, Throwable t) {
                    progressDialog.dismiss();
                    Log.e(TAG, "error" + t.toString());
                    if (iDonateSharedPreference.getsocialMedia(getApplicationContext()).equalsIgnoreCase("email")) {
                        Log.e("data232email", "" + "email");
                        signOut();
                        // Toast.makeText(LoginActivity.this, message, Toast.LENGTH_SHORT).show();
                    } else if (iDonateSharedPreference.getsocialMedia(getApplicationContext()).equalsIgnoreCase("facebook")) {
                        Log.e("data232facebook", "" + "facebook");
                        FacebookSdk.sdkInitialize(getApplicationContext());
                        LoginManager.getInstance().logOut();

                    }
                }
            });
        } catch (Exception e) {
            e.printStackTrace();
            Log.e("Exception", "" + e);
        }
    }

    private void signOut() {
        Auth.GoogleSignInApi.signOut(mGoogleApiClient).setResultCallback(
                new ResultCallback<Status>() {
                    @Override
                    public void onResult(Status status) {
                        Log.e("logout", "logout");
                        ChangeActivity.changeActivity(RegisterActivity.this, RegisterActivity.class);
                        finish();
                    }
                });
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        callbackManager.onActivityResult(requestCode, resultCode, data);

        if (requestCode == RC_SIGN_IN) {
            GoogleSignInResult result = Auth.GoogleSignInApi.getSignInResultFromIntent(data);
            handleSignInResult(result);
            Log.e(TAG, "Got cached sign-in1");
        }
        if (client != null)
            client.onActivityResult(requestCode, resultCode, data);

        // Pass the activity result to the login button.
        twitter_login_btn.onActivityResult(requestCode, resultCode, data);
    }

    private void getUserProfile(AccessToken currentAccessToken) {
        GraphRequest request = GraphRequest.newMeRequest(
                currentAccessToken, new GraphRequest.GraphJSONObjectCallback() {
                    @Override
                    public void onCompleted(JSONObject object, GraphResponse response) {
                        Log.e("objectresponse", "" + object.toString());
                        try {
                            String personName = object.getString("first_name");
                            String last_name = object.getString("last_name");
                            String email = object.getString("email");
                            String id = object.getString("id");
                            String image_url = "https://graph.facebook.com/" + id + "/picture?type=normal";
                            Log.e("image_url", "" + image_url);
                            Log.e("first_name", "" + personName);
                            String socialname = "facebook";
                            gmailfacebookloginAPI(personName, email, socialname, image_url);

                            //   txtUsername.setText("First Name: " + first_name + "\nLast Name: " + last_name);
                            //  txtEmail.setText(email);
                            // Picasso.with(MainActivity.this).load(image_url).into(imageView);

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                    }
                });

        Bundle parameters = new Bundle();
        parameters.putString("fields", "first_name,last_name,email,id");
        request.setParameters(parameters);
        request.executeAsync();

    }

    @Override
    public void onConnectionFailed(@NonNull ConnectionResult connectionResult) {
        // An unresolvable error has occurred and Google APIs (including Sign-In) will not
        // be available.
        Log.d(TAG, "onConnectionFailed:" + connectionResult);
    }

    private void radiobussi() {
        if (radio_btn_yes.isChecked()) {
            radi_business = "yes";
        } else if (radio_btn_no.isChecked()) {
            radi_business = "no";
        } else {

            radi_business = "";
        }
    }

    public static String getDeviceUniqueID(Activity activity) {
        String device_unique_id = Settings.Secure.getString(activity.getContentResolver(),
                Settings.Secure.ANDROID_ID);
        return device_unique_id;
    }

    private void RegisterAPI() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Loading...");
        progressDialog.show();

        String user_name = reg_name_et.getText().toString().trim();
        String user_password = reg_password_et.getText().toString().trim();
        String user_mobile = reg_mobile_et.getText().toString().trim();
        String user_email = reg_email_et.getText().toString().trim();
        if (type.equalsIgnoreCase("business")) {
            business_name = business_reg_name_et.getText().toString();
        } else {
            business_name = "";
        }
        JsonObject jsonObject1 = new JsonObject();
        jsonObject1.addProperty("name", user_name);
        jsonObject1.addProperty("password", user_password);
        jsonObject1.addProperty("phone", user_mobile);
        jsonObject1.addProperty("email", user_email);
        jsonObject1.addProperty("device_id", getDeviceUniqueID(RegisterActivity.this));
        jsonObject1.addProperty("gender", radi_gender);
        jsonObject1.addProperty("country", country_symbol);
        jsonObject1.addProperty("business_name", business_name);
        jsonObject1.addProperty("type", type);
        jsonObject1.addProperty("terms", "Yes");
        Log.e("jsonObject1", "" + jsonObject1);
        /*   ApiInterface jsonPostService = ApiClient.createService(ApiInterface.class, "http://project975.website/i2-donate/api/");*/
        final String image_url = "";
        apiService =
                ApiClient.getClient().create(ApiInterface.class);
        try {
            Call<JsonObject> call = apiService.newuserregister(jsonObject1);
            call.enqueue(new Callback<JsonObject>() {
                @Override
                public void onResponse(Call<JsonObject> call, Response<JsonObject> response) {
                    progressDialog.dismiss();
                    Log.e(TAG, "" + response.body());
                    Log.e("success", "" + response.body());
                    try {
                        JSONObject jsonObject = new JSONObject(String.valueOf(response.body()));
                        String message = jsonObject.getString("message");
                        if (jsonObject.getString("status").equals("1")) {
                            String data = jsonObject.getString("data");
                            Log.e("data232", "" + data);
                            JSONObject jsonObject1 = new JSONObject(data);
                            Log.e("data232", "" + jsonObject1);
                            // sessionManager.createLoginSession(jsonObject1.getString("user_id"), jsonObject1.getString("email"), jsonObject1.getString("name"), jsonObject1.getString("phone_number"),jsonObject1.getString("photo"),jsonObject1.getString("token"),jsonObject1.getString("status"),jsonObject1.getString("country"),jsonObject1.getString("gender"));
                            // iDonateSharedPreference.setprofiledata(getApplicationContext(), data);
                            // sessionManager.createLoginSession(jsonObject1.getString("user_id"), jsonObject1.getString("email"), jsonObject1.getString("name"),jsonObject1.getString("phone_number"));
                            //  iDonateSharedPreference.setSocialProfileimg(getApplicationContext(), image_url);
                            Toast.makeText(RegisterActivity.this, message, Toast.LENGTH_SHORT).show();
                            ChangeActivity.changeActivity(RegisterActivity.this, LoginActivity.class);
                            finish();
                        } else if (jsonObject.getString("status").equals("0")) {
                            ConstantFunctions.showSnackbar(reg_mobile_et, message, RegisterActivity.this);
                            // Toast.makeText(RegisterActivity.this, message, Toast.LENGTH_SHORT).show();
                        }
                    } catch (JSONException e) {


                    }


                }

                @Override
                public void onFailure(Call<JsonObject> call, Throwable t) {
                    progressDialog.dismiss();
                    Log.e(TAG, t.toString());
                    Log.e("Error", t.toString());

                }
            });
        } catch (Exception e) {
            e.printStackTrace();
            Log.e("Exception", "" + e);
        }
    }

    private void radiofn() {

        if (radio_btn_male.isChecked()) {
            radi_gender = "M";
        } else if (radio_btn_female.isChecked()) {
            radi_gender = "F";
        } else if (radio_btn_orthers.isChecked()) {
            radi_gender = "O";
        } else {

            radi_gender = "";
        }
    }

    @Override
    public void onBackPressed() {
        ChangeActivity.changeActivity(RegisterActivity.this, LoginActivity.class);
        finish();
        super.onBackPressed();
    }

    @Override
    public boolean dispatchTouchEvent(MotionEvent event) {
        View view = getCurrentFocus();
        boolean ret = super.dispatchTouchEvent(event);

        if (view instanceof EditText) {
            View w = getCurrentFocus();
            int scrcoords[] = new int[2];
            w.getLocationOnScreen(scrcoords);
            float x = event.getRawX() + w.getLeft() - scrcoords[0];
            float y = event.getRawY() + w.getTop() - scrcoords[1];

            if (event.getAction() == MotionEvent.ACTION_UP
                    && (x < w.getLeft() || x >= w.getRight()
                    || y < w.getTop() || y > w.getBottom())) {
                InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
                imm.hideSoftInputFromWindow(getWindow().getCurrentFocus().getWindowToken(), 0);
            }
        }
        return ret;
    }

    protected boolean isOnline() {
        ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo netInfo = cm.getActiveNetworkInfo();
        if (netInfo != null && netInfo.isConnectedOrConnecting()) {
            return true;
        } else {
            return false;
        }
    }
}
