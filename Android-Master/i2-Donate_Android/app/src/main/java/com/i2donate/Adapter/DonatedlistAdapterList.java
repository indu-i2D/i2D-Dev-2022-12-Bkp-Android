package com.i2donate.Adapter;

import android.app.Activity;
import android.app.Dialog;
import android.os.Handler;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.recyclerview.widget.RecyclerView;

import com.i2donate.Activity.FollowingActivity;
import com.i2donate.Model.Charitylist;
import com.i2donate.Model.CustomImageView;
import com.i2donate.Model.DonatedCharityList;
import com.i2donate.R;
import com.i2donate.RetrofitAPI.ApiInterface;
import com.i2donate.Session.IDonateSharedPreference;
import com.i2donate.Session.SessionManager;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;


/**
 * Created by Gowrishankar on 14/05/19.
 */
public class DonatedlistAdapterList extends RecyclerView.Adapter<DonatedlistAdapterList.MyViewHolder> {

    private Activity mContext;
    List<HashMap<String, String>> charitylist;
    private ArrayList<DonatedCharityList>  charitylist1;
    List<Charitylist> names;
    int lastPosition = -1;
    int index = 0;
    SessionManager session;
    static HashMap<String, String> userDetails;
    ApiInterface apiService;
     Dialog d;
    private Handler handler = new Handler();
    IDonateSharedPreference iDonateSharedPreference;

//    public DonatedlistAdapterList(Activity mContext, List<HashMap<String, String>> charitylist) {
//        this.mContext = mContext;
//        this.charitylist = charitylist;
//        Log.e("charitylist", "" + charitylist);
//    }

    public DonatedlistAdapterList(FollowingActivity mContext, ArrayList<DonatedCharityList> DonatedCharityList1) {
        this.mContext = mContext;
        this.charitylist1 = DonatedCharityList1;
        this.names = new ArrayList<Charitylist>();
       // this.names.addAll(charitylist1);
        Log.e("charitylist", "" + charitylist1);
        session = new SessionManager(mContext);
        userDetails = session.getUserDetails();
        iDonateSharedPreference = new IDonateSharedPreference();

    }


    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View itemView = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.united_state_adapter1_item, parent, false);

        return new MyViewHolder(itemView);
    }

    @Override
    public void onBindViewHolder(final MyViewHolder holder, final int position) {

        holder.name_tv.setText(charitylist1.get(position).getCharity_name());
        holder.paymentmode_tv.setText(charitylist1.get(position).getPayment_type());
        holder.amount_tv.setText(charitylist1.get(position).getAmount());
        holder.date_tv.setText(charitylist1.get(position).getDate());
//        holder.location_name_tv.setText(charitylist1.get(position).getCharity_name() + " " + charitylist1.get(position).getStreet());
//        holder.like_count_tv.setText(charitylist1.get(position).getLike_count() + " " + "Likes");
//        holder.unlike_count_tv.setText(charitylist1.get(position).getLike_count() + " " + "Likes");
//

    }

    @Override
    public int getItemCount() {
        return charitylist1.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        public TextView name_tv, paymentmode_tv, date_tv, amount_tv;
        public CustomImageView logo_img;
        public ImageView like_icon_img;
        public LinearLayout united_item_layout, donate_linear_layout, like_linear_layout, unlike_linear_layout, follow_linear_layout, unfollow_linear_layout;

        public MyViewHolder(View view) {
            super(view);
            united_item_layout = (LinearLayout) view.findViewById(R.id.united_item_layout);
            donate_linear_layout = (LinearLayout) view.findViewById(R.id.donate_linear_layout);
            name_tv = (TextView) view.findViewById(R.id.name_tv);
            paymentmode_tv = (TextView) view.findViewById(R.id.paymentmode_tv);
            date_tv = (TextView) view.findViewById(R.id.date_tv);
            amount_tv = (TextView) view.findViewById(R.id.amount_tv);
//            logo_img = (CustomImageView) view.findViewById(R.id.logo_img);
//            like_count_tv = (TextView) view.findViewById(R.id.like_count_tv);
//            unlike_count_tv = (TextView) view.findViewById(R.id.unlike_count_tv);
//            like_icon_img = (ImageView) view.findViewById(R.id.like_icon_img);
//            follow_count_tv = (TextView) view.findViewById(R.id.follow_count_tv);
//            unfollow_count_tv = (TextView) view.findViewById(R.id.unfollow_count_tv);
//            like_linear_layout = (LinearLayout) view.findViewById(R.id.like_linear_layout);
//            unlike_linear_layout = (LinearLayout) view.findViewById(R.id.unlike_linear_layout);
//            follow_linear_layout = (LinearLayout) view.findViewById(R.id.follow_linear_layout);
//            unfollow_linear_layout = (LinearLayout) view.findViewById(R.id.unfollow_linear_layout);
        }
    }

}