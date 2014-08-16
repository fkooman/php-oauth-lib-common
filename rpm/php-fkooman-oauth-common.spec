%global composer_vendor  fkooman
%global composer_project oauth-common

%global github_owner     fkooman
%global github_name      php-oauth-lib-common

Name:       php-%{composer_vendor}-%{composer_project}
Version:    0.5.0
Release:    1%{?dist}
Summary:    Common PHP classes for OAuth functionality

Group:      Applications/Internet
License:    ASL 2.0
URL:        https://github.com/%{github_owner}/%{github_name}
Source0:    https://github.com/%{github_owner}/%{github_name}/releases/download/%{version}/%{name}-%{version}.tar.xz
BuildArch:  noarch

Provides:   php-composer(%{composer_vendor}/%{composer_project}) = %{version}

Requires:   php >= 5.3.3

%description
This library aims to contain all classes that can be shared between various
OAuth libraries and applications.

%prep
%setup -q

%build

%install
mkdir -p ${RPM_BUILD_ROOT}%{_datadir}/php/%{composer_vendor}/OAuth/Common
cp -pr src/%{composer_vendor}/OAuth/Common/* ${RPM_BUILD_ROOT}%{_datadir}/php/%{composer_vendor}/OAuth/Common

%files
%defattr(-,root,root,-)
%dir %{_datadir}/php/%{composer_vendor}/OAuth/Common
%{_datadir}/php/%{composer_vendor}/OAuth/Common
%doc README.md CHANGES.md COPYING composer.json

%changelog
* Sat Aug 16 2014 François Kooman <fkooman@tuxed.net> - 0.5.0-1
- initial package
