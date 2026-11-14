#!/bin/bash
systemctl enable laravel-schedule.service
systemctl enable laravel-schedule.timer
systemctl enable laravel-worker.service

exec /lib/systemd/systemd
