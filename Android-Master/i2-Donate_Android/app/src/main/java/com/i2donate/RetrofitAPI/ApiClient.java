package com.i2donate.RetrofitAPI;


import java.util.concurrent.TimeUnit;

import okhttp3.OkHttpClient;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;


public class ApiClient {

    //public static final String BASE_URL = "http://project975.website/i2-donate/api/";
    public static final String BASE_URL = "https://test.i2-donate.com/webservice/";
//    public static final String BASE_URL = "https://imaginetventures.org/i2donate/webservice/";
    // public static final String BASE_URL = "https://admin.i2-donate.com/webservice/";
    //public static final String BASE_URL ="http://project975.website/i2donate/webservice/";
    private static Retrofit retrofit = null;
    private static OkHttpClient.Builder httpClient = new OkHttpClient.Builder()
            .connectTimeout(20, TimeUnit.SECONDS)
            .readTimeout(30, TimeUnit.SECONDS)
            .writeTimeout(30, TimeUnit.SECONDS);

   /* public static <S> S createService(Class<S> serviceClass, String baseUrl) {

        Retrofit builder = new Retrofit.Builder()
                .baseUrl(baseUrl)
                .addConverterFactory(GsonConverterFactory.create())
                .client(httpClient.build())
                .build();

        return builder.create(serviceClass);
    }*/

    public static Retrofit getClient() {
        if (retrofit==null) {
            retrofit = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .addConverterFactory(GsonConverterFactory.create())
                    .client(httpClient.build())
                    .build();
        }
        return retrofit;
    }

}
