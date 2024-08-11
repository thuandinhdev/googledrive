# Google Drive API using PHP
- Feature: Create folder, Upload file, View/Download files
- Ref: 
-- 1) https://developers.google.com/resources/api-libraries/documentation/drive/v3/php/latest/class-Google_Service_Drive.html

## Set credentials.json
``
{
  "type": "service_account",
  "project_id": "YOUR_PROJECT_ID",
  "private_key_id": "YOUR_PRIVATE_KEY_ID",
  "private_key": "-----BEGIN PRIVATE KEY-----XXXX_YOUR_PRIVATE_KEY_XXXX-----END PRIVATE KEY-----\n",
  "client_email": "YOUR_CLIENT_EMAIL.iam.gserviceaccount.com",
  "client_id": "YOUR_CLIENT_ID",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token",
  "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/YOUR_CORRECT_CERT_URL.iam.gserviceaccount.com"
}
``