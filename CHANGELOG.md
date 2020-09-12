# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.2.0] 2020-09-12

### Fixed

- Calling `Model::paginate()` will no longer raise an error.

### Added

- New Folded exclusive method `Model::toPage(2)` to go to a specific page before calling `->paginate(15)`.

## [0.1.1] 2020-09-10

### Fixed

- Bug when calling `disableEloquentEvents()` would raise an error.

## [0.1.0] 2020-09-10

### Added

- First working version.
