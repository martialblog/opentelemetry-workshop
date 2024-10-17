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

~~~SECTION:handouts~~~

See: https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver

* https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver/hostmetricsreceiver
* https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver/filelogreceiver
* https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver/mysqlreceiver
* https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver/nginxreceiver
* https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver/syslogreceiver

~~~ENDSECTION~~~

!SLIDE

# Distributions

For various reasons the existing distributions provided by the OpenTelemetry project may not meet your needs. Whether you want a smaller version, or have the need to implement custom functionality like authenticator extensions, receivers, processors, exporters or connectors.

The tool used to build distributions ocb (OpenTelemetry Collector Builder) is available to build your own distributions.

!SLIDE

# OTLP

The OpenTelemetry Protocol (OTLP) specification describes the encoding, transport, and delivery mechanism of telemetry data between telemetry sources, intermediate nodes such as collectors and telemetry backends.

This specification defines how OTLP is implemented over gRPC and HTTP

See: https://opentelemetry.io/docs/specs/otlp/
