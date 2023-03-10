package com.i2donate.Activity;

import android.graphics.Color;
import android.net.http.SslError;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.webkit.SslErrorHandler;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ImageView;

import androidx.appcompat.app.AppCompatActivity;

import com.i2donate.R;

public class PrivacyPolicyActivity extends AppCompatActivity {
    WebView webView;
    ImageView back_icon_img;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_privacy_policy);
        init();
        listioner();
    }
    private void init() {
        webView=(WebView)findViewById(R.id.webView);
        back_icon_img=(ImageView) findViewById(R.id.back_icon_img);
        webView.getSettings().setJavaScriptEnabled(true);
        webView.getSettings();
        webView.setBackgroundColor(Color.TRANSPARENT);
        webView.setScrollbarFadingEnabled(true);
        WebSettings webSettings = webView.getSettings();
        // webSettings.setTextSize(WebSettings.TextSize.SMALLEST);
        // webView.loadUrl("https://admin.i2-donate.com/terms_conditions.html");
        webView.loadUrl("https://test.i2-donate.com/i2D-Publish-Docs/i2-Donate%20Privacy%20Policy.html");
        webSettings.setTextZoom(webSettings.getTextZoom() - 40);
        webView.setWebViewClient(new MyWebViewClient());

    }

    private class MyWebViewClient extends WebViewClient {
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
            Log.e("response_html11",""+url);
            // Otherwise, the link is not for a page on my site, so launch another Activity that handles URLs
           /* Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(url));
            startActivity(intent);*/
            return true;
        }

        @Override
        public void onReceivedSslError(WebView view, SslErrorHandler handler, SslError error) {
            handler.proceed();
        }
    }

    private void listioner() {
        back_icon_img.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        finish();
    }
}