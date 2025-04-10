package com.essenceelegance.timeapi.resolver;

import com.essenceelegance.timeapi.model.TimeResponse;
import org.springframework.graphql.data.method.annotation.Argument;
import org.springframework.graphql.data.method.annotation.QueryMapping;
import org.springframework.stereotype.Controller;

import java.time.ZoneId;
import java.time.ZonedDateTime;

@Controller
public class TimeResolver {

    @QueryMapping
    public TimeResponse currentTime(@Argument(name = "timezone", defaultValue = "UTC") String timezone) {
        ZoneId zoneId;
        try {
            zoneId = ZoneId.of(timezone);
        } catch (Exception e) {
            // Default to UTC if timezone is invalid
            zoneId = ZoneId.of("UTC");
        }
        
        ZonedDateTime now = ZonedDateTime.now(zoneId);
        return new TimeResponse(now);
    }
}
