!SLIDE

# Receivers

Receivers typically listen on a network port and receive telemetry data.

They can also actively obtain data, like scrapers.

Usually one receiver is configured to send received data to one pipeline.

    @@@Yaml
    receivers:
      filelog:
        include: [ /var/log/myservice/*.json ]
        operators:
          - type: json_parser
            timestamp:
              parse_from: attributes.time
              layout: '%Y-%m-%d %H:%M:%S'

See: https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver

!SLIDE

# Processor

Processors take the data collected by receivers and modify or transform it before sending it to the exporters.

This might include filtering, dropping, renaming, or recalculating telemetry.

    @@@Yaml
    processors:
      logs:
        log_record:
          - 'IsMatch(body, ".*password.*")'
      memory_limiter:
        limit_mib: 4000
      batch:
    service:
      pipelines:
        logs:
          receivers: [otlp]
          processors: [memory_limiter, logs, batch]
          exporters: [otlp]

See: https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/processor

!SLIDE

# Distributions

The OpenTelemetry project provides compiled distributions of the collector.

But you easily build your own with the `ocb` tool (OpenTelemetry Collector Builder).

When you need custom functionality like authenticator extensions, receivers, processors, exporters or connectors.

https://opentelemetry.io/docs/collector/distributions/

!SLIDE

# OTLP

The OpenTelemetry Protocol (OTLP) defines the encoding of telemetry data and the protocol used to exchange data between the client and the server.

This specification defines how OTLP is implemented over gRPC and HTTP.

More and more vendors offer data ingestion via OTLP natively.

See: https://opentelemetry.io/docs/specs/otlp/
