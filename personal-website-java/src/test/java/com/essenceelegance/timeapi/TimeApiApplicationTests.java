package com.essenceelegance.timeapi;

import org.junit.jupiter.api.Test;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.graphql.test.tester.GraphQlTester;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.graphql.test.tester.HttpGraphQlTester;

@SpringBootTest(webEnvironment = SpringBootTest.WebEnvironment.RANDOM_PORT)
class TimeApiApplicationTests {

    @Autowired
    private GraphQlTester graphQlTester;

    @Test
    void contextLoads() {
    }

    @Test
    void shouldReturnCurrentTime() {
        String query = """
                query {
                    currentTime {
                        currentTime
                        date
                        timezone
                        hour
                        minute
                        second
                        timestamp
                    }
                }
                """;

        graphQlTester.document(query)
                .execute()
                .path("currentTime")
                .hasValue()
                .path("currentTime.timezone")
                .entity(String.class)
                .isEqualTo("UTC");
    }
}
