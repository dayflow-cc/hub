#!/usr/bin/env bash

# make pam_loginuid.so optional for cron
# see https://github.com/docker/docker/issues/5663#issuecomment-42550548
sed -i 's/^\s*session\s\+required\s\+pam_loginuid.so/# &/' /etc/pam.d/cron

# make sure ENV is available in docker scripts
printenv >> /etc/environment
