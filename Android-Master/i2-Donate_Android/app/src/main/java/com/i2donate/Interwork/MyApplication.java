package com.i2donate.Interwork;

import android.app.Application;
import android.util.Log;

import com.facebook.FacebookSdk;
import com.facebook.appevents.AppEventsLogger;

public class MyApplication extends Application {

    private static MyApplication mInstance;

    @Override
    public void onCreate() {
        super.onCreate();

        FacebookSdk.sdkInitialize(getApplicationContext());
        AppEventsLogger.activateApp(this);
        mInstance = this;
    }

    public static synchronized MyApplication getInstance() {
        if (mInstance==null){
            Log.e("mInstance","null");
        }else {
            Log.e("mInstance",""+mInstance);
        }
        return mInstance;
    }

    public void setConnectivityListener(ConnectivityReceiver.ConnectivityReceiverListener listener) {
        ConnectivityReceiver.connectivityReceiverListener = listener;
    }
}
