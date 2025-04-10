package com.essenceelegance.timeapi.model;

import java.time.LocalDateTime;
import java.time.ZonedDateTime;

public class TimeResponse {
    private String currentTime;
    private String date;
    private String timezone;
    private int hour;
    private int minute;
    private int second;
    private long timestamp;

    public TimeResponse(ZonedDateTime time) {
        this.currentTime = time.toLocalTime().toString();
        this.date = time.toLocalDate().toString();
        this.timezone = time.getZone().toString();
        this.hour = time.getHour();
        this.minute = time.getMinute();
        this.second = time.getSecond();
        this.timestamp = time.toEpochSecond();
    }

    public String getCurrentTime() {
        return currentTime;
    }

    public String getDate() {
        return date;
    }

    public String getTimezone() {
        return timezone;
    }

    public int getHour() {
        return hour;
    }

    public int getMinute() {
        return minute;
    }

    public int getSecond() {
        return second;
    }

    public long getTimestamp() {
        return timestamp;
    }
}
