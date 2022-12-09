package com.i2donate.Validation;

public class Validation {

    public static String emailPattern = "[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\\.+[a-z]+";
    public static String PASSWORD_PATTERN = "(?=.*?\\d)(?=.*?[a-zA-Z])(?=.*[*()_|<>?{}\\[\\]~;:,/.?@#$%^!&+={|}])(?=\\S+$).{8,}";
//    public static String NAME_PATTERN = "^(?!\\d+$)(?:[a-zA-Z0-9][a-zA-Z0-9 @&$]*)?$";
    public static String NAME_PATTERN = "[a-zA-Z /-]+";

    public static String NAMEPATTERN = "[a-zA-Z ]+";
//            "((?=.*\\d)(?=.*[a-zA-Z])(?=.*[a-zA-Z0-9])(?=.*[@#$%]).{6,20})";
    //  public static String PASSWORD_PATTERN="(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{6,50})$";
}
