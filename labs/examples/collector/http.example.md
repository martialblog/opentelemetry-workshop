# HTTP Example

Update the configuration:

```
receivers:
  httpcheck:
    targets:
      - endpoint: http://endpoint:80
        method: GET
      - endpoint: http://localhost:80/health
        method: GET
    collection_interval: 10s

processors:
  batch:

exporters:
  otlphttp/prom:
    endpoint: 'http://192.168.0.1:9090/api/v1/otlp'
  otlphttp/loki:
    endpoint: 'http://192.168.0.1:3100/otlp/'
  otlp/jaeger:
    endpoint: jaeger:4317
    tls:
      insecure: true

service:
  pipelines:
    metrics:
      receivers: [httpcheck]
      processors: [batch]
      exporters: [otlphttp/prom]
```

```
systemctl restart otelcol-contrib.service
```
