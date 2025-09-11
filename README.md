<img alt='seven.io Logo' src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" />

# seven SMS Plugin for plentymarkets

Send SMS messages automatically when orders are placed or trigger them manually using the seven.io SMS gateway.

## Overview

The seven SMS plugin integrates your plentymarkets store with seven.io's SMS service to:

- Automatically send SMS notifications when customers place orders
- Customize message content and sender information
- Use property placeholders, e.g. {{order.id}} or {{contactReceiver.fullName}}

## Prerequisites

Before installing the plugin, you need:

- A plentymarkets system (version 7.0 or higher)
- A seven.io account and API key
- PHP 8.0 or higher (automatically handled by plentymarkets)

## Getting Your seven.io API Key

1. Sign up for a seven.io account at [seven.io](https://seven.io)
2. Log into your seven.io dashboard
3. Navigate to your API settings
4. Copy your API key

For detailed instructions, visit: https://help.seven.io/en/articles/9582186-where-do-i-find-my-api-key

## Installation

### Via plentyMarketplace (soon)

1. Go to **System » Plugins » plentyMarketplace**
2. Search for "seven SMS" or "seven Text Messaging"
3. Click **Install** on the seven plugin
4. Navigate to **System » Plugins » Plugin overview**
5. Find the seven plugin and click **Deploy**
6. Activate the plugin for your client store

### Manual Installation (Development)

1. Download or clone this plugin
2. Upload the plugin folder to your plentymarkets plugin directory
3. Go to **System » Plugins » Plugin overview**
4. Click **Update plugins** to detect the new plugin
5. Deploy and activate the plugin

## Configuration

After installation, configure the plugin:

1. Go to **System » Plugins » Plugin overview**
2. Find the seven plugin and click the **gear icon** (Settings)
3. Configure the following settings:

   ### General Settings

    - **API Key**: Enter your seven.io API key (required)
        - This key authenticates your plentymarkets store with seven.io
        - Keep this key secure and never share it publicly

   ### SMS Settings

    - **Default Sender ID**: Set a custom sender name/number (optional)
        - This appears as the sender when customers receive SMS messages
        - If left empty, seven.io's default sender will be used
        - Must comply with local regulations (some countries require registration)

   ### Event-Driven Settings

    - **Message after ordering**: Customize the SMS text sent when orders are placed
        - This message is automatically sent to customers after successful order placement
        - You can use placeholder variables for dynamic content (order number, customer name, etc.)
        - Example: "Thank you for your order! Your order #{{orderNumber}} has been received and will be processed
          shortly."

4. Click **Save** to apply your configuration

## Setting Up Automatic SMS Notifications

To automatically send SMS messages when orders are placed:

1. Go to **System » Orders » Events**
2. Click **Add event procedure**
3. Configure the event:
    - **Name**: "Send SMS on Order Creation" (or your preferred name)
    - **Event**: Select "New order"
    - **Filter**: Add any conditions (optional, e.g., specific payment methods)
    - **Procedure**: Select "seven | Send SMS"

4. **Save** the event procedure
5. **Activate** the event procedure

## Usage

### Automatic SMS Sending

Once configured and activated, the plugin will:

- Monitor new orders in your plentymarkets system
- Automatically send SMS notifications to customers using their order phone number
- Use the message template you configured in the plugin settings

### Manual SMS Sending

You can also send SMS messages manually through the plugin interface:

1. Go to **System » Plugins** and find seven in the menu
2. Access the seven SMS interface
3. Enter recipient phone number and message
4. Click **Send**

## Troubleshooting

### SMS Messages Not Sending

1. **Check API Key**: Verify your seven.io API key is correct
2. **Check Balance**: Ensure you have sufficient credits in your seven.io account
3. **Check Phone Numbers**: Verify phone numbers are in international format (+country code)
4. **Check Event Procedures**: Ensure the event procedure is active and properly configured
5. **Check Logs**: Review plentymarkets logs for error messages

### Common Issues

- **API Key Invalid**: Double-check your API key in the plugin settings
- **Insufficient Credits**: Top up your seven.io account balance
- **Invalid Phone Number"**: Ensure phone numbers include country code (e.g., +1234567890)
- **Messages Not Triggered**: Verify your event procedures are active and filters are correct

### Log Files

Check plentymarkets logs for detailed error information:

- Go to **System » System log**
- Filter by "seven" to see plugin-related entries

## Support

For technical support:

- **Plugin Issues**: Contact seven.io support at support@seven.io
- **seven.io API Issues**: Visit [seven.io Help Center](https://help.seven.io)
- **plentymarkets Issues**: Contact plentymarkets support

## Features

- ✅ Automatic SMS sending on order creation
- ✅ Custom sender ID support
- ✅ Event procedure integration
- ✅ Multi-language support (English/German)
- ✅ Detailed logging and error reporting

## Version Information

- **Current Version**: 0.0.1
- **Minimum PHP**: 8.0
- **plentymarkets Compatibility**: 7.0+

## License

Copyright by seven communications GmbH & Co. KG

---

**Need help?** Visit [seven.io Help Center](https://help.seven.io) or contact support at support@seven.io
