<?php

    function is_shutdown($settings) {
        return $settings->shutdown || ($settings->shutdown_datetime != "" && date_create_from_format('Y-m-d\TH:i', $settings->shutdown_datetime) < new DateTime());
    }
