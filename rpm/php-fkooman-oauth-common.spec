%global composer_vendor  fkooman
%global composer_project oauth-common

%global github_owner     fkooman
%global github_name      php-oauth-lib-common

Name:       php-%{composer_vendor}-%{composer_project}
Version:    0.7.0
Release:    1%{?dist}
Summary:    Common PHP classes for OAuth functionality

Group:      System Environment/Libraries
License:    ASL 2.0
URL:        https://github.com/%{github_owner}/%{github_name}
Source0:    https://github.com/%{github_owner}/%{github_name}/archive/%{version}.tar.gz
BuildArch:  noarch

Provides:   php-composer(%{composer_vendor}/%{composer_project}) = %{version}

Requires:   php >= 5.3.3

%description
This library aims to contain all classes that can be shared between various
OAuth libraries and applications.

%prep
%setup -qn %{github_name}-%{version}

%build

%install
mkdir -p ${RPM_BUILD_ROOT}%{_datadir}/php
cp -pr src/* ${RPM_BUILD_ROOT}%{_datadir}/php

%files
%defattr(-,root,root,-)
%dir %{_datadir}/php/%{composer_vendor}/OAuth/Common
%{_datadir}/php/%{composer_vendor}/OAuth/Common/*
%doc README.md CHANGES.md COPYING composer.json

%changelog
* Sun Oct 26 2014 François Kooman <fkooman@tuxed.net> - 0.7.0-1
- update to 0.7.0

* Wed Oct 22 2014 François Kooman <fkooman@tuxed.net> - 0.6.1-2
- update to 0.6.1

* Mon Oct 20 2014 François Kooman <fkooman@tuxed.net> - 0.6.0-1
- update to 0.6.0

* Sat Aug 30 2014 François Kooman <fkooman@tuxed.net> - 0.5.0-2
- use github tagged release sources
- update group to System Environment/Libraries

* Sat Aug 16 2014 François Kooman <fkooman@tuxed.net> - 0.5.0-1
- initial package
