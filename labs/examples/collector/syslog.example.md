# rsyslog Example

Update rsyslog:

```
cat /etc/rsyslog.d/otel.conf
*.* @127.0.0.1:1514;RSYSLOG_SyslogProtocol23Format

systemctl restart rsyslog
```

Update the configuration:

```
receivers:
  syslog:
    udp:
      listen_address: "0.0.0.0:1514"
    protocol: rfc5424

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
    logs:
      receivers: [syslog]
      processors: [batch]
      exporters: [otlphttp/loki]
```

```
systemctl restart otelcol-contrib.service
```
