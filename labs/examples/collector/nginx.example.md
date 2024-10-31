# Nginx Example

Install nginx and setup JSON logging:

```
apt install nginx

vi /etc/nginx/nginx.conf


log_format json_combined escape=json '{'
    '"time_local":"$time_local",'
    '"remote_addr":"$remote_addr",'
    '"request":"$request",'
    '"status": "$status",'
    '"body_bytes_sent":"$body_bytes_sent",'
    '"http_referer":"$http_referer",'
    '"http_user_agent":"$http_user_agent",'
    '"request_time":"$request_time",'
    '"upstream_response_time":"$upstream_response_time",'
    '"upstream_addr":"$upstream_addr",'
    '"upstream_status":"$upstream_status"'
'}';

access_log /var/log/nginx/access.log json_combined;
```

Install Collector (contrib, which includes more receivers):

```
wget https://github.com/open-telemetry/opentelemetry-collector-releases/releases/download/v0.112.0/otelcol-contrib_0.112.0_linux_amd64.deb
dpkg -i otelcol-contrib_0.112.0_linux_amd64.deb
```

Update the configuration:

```
vi /etc/otelcol-contrib/config.yaml

receivers:
  filelog:
    include: [ /var/log/nginx/access.log ]
    operators:
      - type: json_parser
        timestamp:
          parse_from: attributes.time_local
          layout: '%d/%b/%Y:%H:%M:%S %z'

processors:
  batch:

exporters:
  otlphttp/prom:
    endpoint: 'http://192.168.0.1:9090/api/v1/otlp/'
  otlphttp/loki:
    endpoint: 'http://192.168.0.1:3100/otlp/'
  otlp/jaeger:
    endpoint: jaeger:4317
    tls:
      insecure: true

service:
  pipelines:
    logs:
      receivers: [filelog]
      processors: [batch]
      exporters: [otlphttp/loki]

```

```
systemctl restart otelcol-contrib.service
```
