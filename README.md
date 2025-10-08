# contao-packagist-info-bundle

Provides a content element and an insert tag to display information about packages from Packagist.\
Package information is cached for 10 minutes to reduce the number of API requests.

## Insert tag usage

`{{packagist::vendor/package::attribute}}`

- `vendor/package`: The name of the package on Packagist (e.g., `lukasbableck/contao-packagist-info-bundle`).
- `attribute`: The attribute to display. Possible values are:
  - `name`: The name of the package.
  - `description`: The description of the package.
  - `lastUpdated`: The date when the package was last updated.
  - `versions`: The available versions of the package.
  - `latestStableVersion`: The latest stable version of the package.
  - `repository`: The URL to the package's repository.
  - `downloads`: The numbers of downloads.
  - `totalDownloads`: The total number of downloads.
  - `favers`: The total number of users who have favorited the package.
  - `githubStars`: The number of stars on GitHub (if applicable).
  - `githubForks`: The number of forks on GitHub (if applicable).
  - `githubWatchers`: The number of watchers on GitHub (if applicable).
  - `githubOpenIssues`: The number of open issues on GitHub (if applicable).
  - `language`: The programming language of the package.
  - `compatibleContaoVersions`: The Contao versions supported by the package.
