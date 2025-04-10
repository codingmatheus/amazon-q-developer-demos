# Time GraphQL API

This is a Spring Boot GraphQL API that provides the current time information.

## Features

- Get current time in different timezones
- Returns time in various formats (formatted time, individual components, timestamp)
- Built with Spring Boot and GraphQL

## Running the Application

1. Make sure you have Java 17 or higher installed
2. Build the application:
   ```
   ./mvnw clean package
   ```
3. Run the application:
   ```
   ./mvnw spring-boot:run
   ```
4. Access the GraphiQL interface at: http://localhost:8080/graphiql

## API Usage

### Query the current time

```graphql
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
```

### Query the current time with a specific timezone

```graphql
query {
  currentTime(timezone: "America/New_York") {
    currentTime
    date
    timezone
    hour
    minute
    second
    timestamp
  }
}
```

## Response Example

```json
{
  "data": {
    "currentTime": {
      "currentTime": "14:30:45",
      "date": "2025-04-03",
      "timezone": "UTC",
      "hour": 14,
      "minute": 30,
      "second": 45,
      "timestamp": 1743873045
    }
  }
}
```

## Project Structure

```
/
├── src/
│   ├── main/
│   │   ├── java/
│   │   │   └── com/
│   │   │       └── essenceelegance/
│   │   │           └── timeapi/
│   │   │               ├── TimeApiApplication.java
│   │   │               ├── model/
│   │   │               │   └── TimeResponse.java
│   │   │               └── resolver/
│   │   │                   └── TimeResolver.java
│   │   └── resources/
│   │       ├── application.properties
│   │       └── graphql/
│   │           └── schema.graphqls
│   └── test/
│       └── java/
│           └── com/
│               └── essenceelegance/
│                   └── timeapi/
│                       └── TimeApiApplicationTests.java
└── pom.xml
```
