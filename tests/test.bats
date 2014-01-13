#!/usr/bin/env bats

@test "no args" {
  line1="$(mewsh|head -1)"
  [[ $result =~ ^mewsh ]]
}