# Re-search plugin for Craft CMS 3.x

Extending the native Craft search

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require ournameismud/research

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Research.

## Research Overview

-Insert text here-

## Configuring Research

-Insert text here-

## Using Research


Provides a new `{{ craft.research.get($criteria, $type) }}` variable which acts as a router for native search queries but logs a record of the query in the database.

`$criteria` represents the same parameters that can be passed to any native element query in Craft.
`$type` is optional but specifies the element type queried. Available options are:

- `entries` (default)
- `categories`
- `assets`
- `matrix`
- `tags`
- `users`

The variable returns an array of objects for use as per `craft.entries`, `craft.tags`, etc.

Sample code:

```
{% set q = craft.request.param('q') %}
{% paginate craft.research.get({ search: q }).limit(10) as info, entries%}

{% for entry in entries %}
	<h2>{{ entry.title }}</h2>
	<p>{{ entry.section }}, {{ entry.searchScore }}</p>
{% endfor %}
```

The logs are visible in the Control Panel

## Research Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [@cole007](http://ournameismud.co.uk/)
Search icon by AomAm from the Noun Project