# AWS Glue Event Processor

This CDK application demonstrates how to capture AWS Glue CreateSession events and process them using AWS Step Functions.

## Architecture

The application sets up the following components:

1. **CloudWatch Events Rule**: Captures AWS Glue CreateSession API calls via CloudTrail
2. **Step Function**: Processes the captured events
3. **Demo Glue Database**: Created for demonstration purposes

## Prerequisites

- AWS CDK installed
- AWS CLI configured with appropriate permissions
- Python 3.6 or later

## Deployment

1. Create and activate a virtual environment:
   ```
   python3 -m venv .venv
   source .venv/bin/activate
   ```

2. Install dependencies:
   ```
   pip install -r requirements.txt
   ```

3. Deploy the stack:
   ```
   cdk deploy
   ```

## Testing

To test the application:

1. Create a Glue Session using the AWS Console or CLI:
   ```
   aws glue create-session --default-database demo_glue_database --role-arn <YOUR_ROLE_ARN>
   ```

2. Check the CloudWatch Logs group `/aws/stepfunctions/glue-events` to see the processed event.

## Cleanup

To remove all resources created by this application:

```
cdk destroy
```
