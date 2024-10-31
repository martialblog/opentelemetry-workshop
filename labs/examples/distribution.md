# Custom Distribution

Download the OpenTelemetry Collector Builder (ocb):

```
wget https://github.com/open-telemetry/opentelemetry-collector-releases/releases/download/cmd%2Fbuilder%2Fv0.112.0/ocb_0.112.0_linux_amd64

chmod +x ocb_0.112.0_linux_amd64
```

Create a configuration:

```yaml
vi manifest.yaml

dist:
  name: otelcol-osmc
  description: Basic OTel Collector distribution for fun
  output_path: ./otelcol-osmc
  otelcol_version: 0.112.0

exporters:
  - gomod:
      go.opentelemetry.io/collector/exporter/debugexporter v0.112.0
  - gomod:
      go.opentelemetry.io/collector/exporter/otlpexporter v0.112.0

processors:
  - gomod:
      go.opentelemetry.io/collector/processor/batchprocessor v0.112.0

receivers:
  - gomod:
      go.opentelemetry.io/collector/receiver/otlpreceiver v0.112.0

providers:
  - gomod: go.opentelemetry.io/collector/confmap/provider/envprovider v1.18.0
  - gomod: go.opentelemetry.io/collector/confmap/provider/yamlprovider v1.18.0
```

Build the distribution:

```
./ocb_0.112.0_linux_amd64 --config=manifest.yml
```
