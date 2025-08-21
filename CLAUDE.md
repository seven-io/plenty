# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is the official Seven SMS plugin for PlentyMarkets e-commerce platform. It integrates with Seven.io's SMS gateway API to send text messages triggered by order events and through manual dispatch.

## Architecture

### Plugin Structure
- **Service Provider Pattern**: `SevenServiceProvider` is the main entry point, registering routes and event procedures
- **MVC Architecture**: Controllers handle HTTP requests, with views rendered via Twig templates
- **Event-Driven SMS**: Uses PlentyMarkets' EventProcedures system to trigger SMS sending on order events
- **Configuration Management**: Plugin configuration stored in PlentyMarkets config system, accessed via `ConfigRepository`

### Key Components

**Core Services**:
- `SevenServiceProvider.php:18` - Main service provider, registers event procedures and routes
- `SevenRouteServiceProvider.php:12` - Defines HTTP routes for the plugin
- `Procedures.php:11` - Handles SMS dispatch logic for order and reorder events

**Controllers & Views**:
- `SevenController.php:9` - Basic controller with hello world endpoint
- `Index.twig:1` - Main view template for plugin interface
- `SevenDataProvider.php:7` - Data provider for rendering content containers

**Configuration**:
- Configuration schema defined in `config.json:3` with API key and event text settings
- UI configuration in `ui.json:3` defines menu entries and interface structure
- Multi-language support via properties files in `resources/lang/`

### SMS Integration

The plugin integrates with Seven.io API in two ways:
1. **Direct cURL**: Used in `Procedures.php:41` for immediate SMS dispatch
2. **Library Call**: Alternative method via `seven_connector.php:17` using Seven.io's official PHP SDK

Event procedures are registered for:
- Order creation (`EVENT_TYPE_ORDER`)
- Reorder events (`EVENT_TYPE_REORDER`)

## Development Commands

### Composer
```bash
composer install    # Install PHP dependencies
```

### Dependencies
- PHP >= 8.0
- Seven.io API SDK v7.0.0 (composer) / v3.0.0 (plugin dependency)
- PlentyMarkets plugin framework

## Plugin Deployment

This plugin follows PlentyMarkets plugin structure:
- Must be deployed in directory structure: `<plenty_id>/2/Seven`
- Plugin ID and credentials change every 30 days in development environment
- Current development environment uses ID format like `66583/2/Seven`

## API Configuration

The plugin requires a Seven.io API key configured via:
- PlentyMarkets admin interface under plugin settings
- Configuration key: `Seven.general.apiKey`
- Additional settings: `Seven.events.postCreateOrderText` for custom SMS content

## Logging

The plugin uses PlentyMarkets logging system:
- Logger identifier: `'seven'`
- Reference container: `'seven'` for log grouping
- Log levels: debug, error logging implemented in event procedures

## File Structure Notes

- `meta/documents/` - Contains user guides and changelogs in German/English
- `resources/lib/seven_connector.php` - Legacy connector implementation
- Plugin metadata in `plugin.json` defines containers, data providers, and marketplace information